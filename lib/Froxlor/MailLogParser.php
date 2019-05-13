<?php
namespace Froxlor;

use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Roman Schmerold <bnoize@froxlor.org>
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 * @since 0.9.32
 *       
 */
class MailLogParser
{

	private $startTime;

	private $domainTraffic = array();

	private $myDomains = array();

	private $mails = array();

	/**
	 * constructor
	 *
	 * @param
	 *        	string logFile
	 * @param
	 *        	int startTime
	 * @param
	 *        	string logFileExim
	 */
	public function __construct($startTime = 0)
	{
		$this->startTime = $startTime;

		// Get all domains from Database
		$stmt = Database::prepare("SELECT domain FROM `" . TABLE_PANEL_DOMAINS . "`");
		Database::pexecute($stmt, array());
		while ($domain_row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$this->myDomains[] = $domain_row["domain"];
		}

		// Parse MTA traffic
		if (Settings::Get("system.mtaserver") == "postfix") {
			$this->parsePostfixLog(Settings::Get("system.mtalog"));
			$this->parsePostfixLog(Settings::Get("system.mtalog") . ".1");
		} elseif (Settings::Get("system.mtaserver") == "exim4") {
			$this->parseExim4Log(Settings::Get("system.mtalog"));
		}

		// Parse MDA traffic
		if (Settings::Get("system.mdaserver") == "dovecot") {
			$this->parseDovecotLog(Settings::Get("system.mdalog"));
			$this->parsePostfixLog(Settings::Get("system.mdalog") . ".1");
		} elseif (Settings::Get("system.mdaserver") == "courier") {
			$this->parseCourierLog(Settings::Get("system.mdalog"));
			$this->parsePostfixLog(Settings::Get("system.mdalog") . ".1");
		}
	}

	/**
	 * parsePostfixLog
	 * parses the traffic from a postfix logfile
	 *
	 * @param string $logFile
	 *        	logFile
	 */
	private function parsePostfixLog($logFile)
	{
		// Check if file exists
		if (! file_exists($logFile)) {
			return false;
		}

		// Open the log file
		try {
			$file_handle = fopen($logFile, "r");
			if (! $file_handle) {
				throw new \Exception("Could not open the file!");
			}
		} catch (\Exception $e) {
			echo "Error (File: " . $e->getFile() . ", line " . $e->getLine() . "): " . $e->getMessage();
			return false;
		}

		while (! feof($file_handle)) {
			unset($matches);
			$line = fgets($file_handle);

			$timestamp = $this->getLogTimestamp($line);
			if ($this->startTime < $timestamp) {
				if (preg_match("/postfix\/qmgr.*(?::|\])\s([A-Z\d]+).*from=<?(?:.*\@([a-zA-Z\d\.\-]+))?>?, size=(\d+),/", $line, $matches)) {
					// Postfix from
					$this->mails[$matches[1]] = array(
						"domainFrom" => strtolower($matches[2]),
						"size" => $matches[3]
					);
				} elseif (preg_match("/postfix\/(?:pipe|smtp).*(?::|\])\s([A-Z\d]+).*to=<?(?:.*\@([a-zA-Z\d\.\-]+))?>?,/", $line, $matches)) {
					// Postfix to
					if (array_key_exists($matches[1], $this->mails)) {
						$this->mails[$matches[1]]["domainTo"] = strtolower($matches[2]);

						// Only mails from/to outside the system should be added
						$mail = $this->mails[$matches[1]];
						if (in_array($mail["domainFrom"], $this->myDomains) || in_array($mail["domainTo"], $this->myDomains)) {
							// Outgoing traffic
							if (array_key_exists("domainFrom", $mail)) {
								$this->addDomainTraffic($mail["domainFrom"], $mail["size"], $timestamp);
							}

							// Incoming traffic
							if (array_key_exists("domainTo", $mail) && in_array($mail["domainTo"], $this->myDomains)) {
								$this->addDomainTraffic($mail["domainTo"], $mail["size"], $timestamp);
							}
						}
						unset($mail);
					}
				}
			}
		}
		fclose($file_handle);
		return true;
	}

	/**
	 * parseExim4Log
	 * parses the smtp traffic from a exim4 logfile
	 *
	 * @param string $logFile
	 *        	logFile
	 */
	private function parseExim4Log($logFile)
	{
		// Check if file exists
		if (! file_exists($logFile)) {
			return false;
		}

		// Open the log file
		try {
			$file_handle = fopen($logFile, "r");
			if (! $file_handle) {
				throw new \Exception("Could not open the file!");
			}
		} catch (\Exception $e) {
			echo "Error (File: " . $e->getFile() . ", line " . $e->getLine() . "): " . $e->getMessage();
			return false;
		}

		while (! feof($file_handle)) {
			unset($matches);
			$line = fgets($file_handle);

			$timestamp = $this->getLogTimestamp($line);
			if ($this->startTime < $timestamp) {
				if (preg_match("/<= .*@([a-z0-9.\-]+) .*S=(\d+)/i", $line, $matches)) {
					// Outgoing traffic
					$this->addDomainTraffic($matches[1], $matches[2], $timestamp);
				} elseif (preg_match("/=> .*<?.*@([a-z0-9.\-]+)>? .*S=(\d+)/i", $line, $matches)) {
					// Incoming traffic
					$this->addDomainTraffic($matches[1], $matches[2], $timestamp);
				}
			}
		}
		fclose($file_handle);
		return true;
	}

	/**
	 * parseDovecotLog
	 * parses the dovecot imap/pop3 traffic from logfile
	 *
	 * @param string $logFile
	 *        	logFile
	 */
	private function parseDovecotLog($logFile)
	{
		// Check if file exists
		if (! file_exists($logFile)) {
			return false;
		}

		// Open the log file
		try {
			$file_handle = fopen($logFile, "r");
			if (! $file_handle) {
				throw new \Exception("Could not open the file!");
			}
		} catch (\Exception $e) {
			echo "Error (File: " . $e->getFile() . ", line " . $e->getLine() . "): " . $e->getMessage();
			return false;
		}

		while (! feof($file_handle)) {
			unset($matches);
			$line = fgets($file_handle);

			$timestamp = $this->getLogTimestamp($line);
			if ($this->startTime < $timestamp) {
				if (preg_match("/dovecot.*(?::|\]) imap\(.*@([a-z0-9\.\-]+)\):.*(?:in=(\d+) out=(\d+)|bytes=(\d+)\/(\d+))/i", $line, $matches)) {
					// Dovecot IMAP
					$this->addDomainTraffic($matches[1], (int) $matches[2] + (int) $matches[3], $timestamp);
				} elseif (preg_match("/dovecot.*(?::|\]) pop3\(.*@([a-z0-9\.\-]+)\):.*in=(\d+).*out=(\d+)/i", $line, $matches)) {
					// Dovecot POP3
					$this->addDomainTraffic($matches[1], (int) $matches[2] + (int) $matches[3], $timestamp);
				}
			}
		}
		fclose($file_handle);
		return true;
	}

	/**
	 * parseCourierLog
	 * parses the dovecot imap/pop3 traffic from logfile
	 *
	 * @param string $logFile
	 *        	logFile
	 */
	private function parseCourierLog($logFile)
	{
		// Check if file exists
		if (! file_exists($logFile)) {
			return false;
		}

		// Open the log file
		try {
			$file_handle = fopen($logFile, "r");
			if (! $file_handle) {
				throw new \Exception("Could not open the file!");
			}
		} catch (\Exception $e) {
			echo "Error (File: " . $e->getFile() . ", line " . $e->getLine() . "): " . $e->getMessage();
			return false;
		}

		while (! feof($file_handle)) {
			unset($matches);
			$line = fgets($file_handle);

			$timestamp = $this->getLogTimestamp($line);
			if ($this->startTime < $timestamp) {
				if (preg_match("/(?:imapd|pop3d)(?:-ssl)?.*(?::|\]).*user=.*@([a-z0-9\.\-]+),.*rcvd=(\d+), sent=(\d+),/i", $line, $matches)) {
					// Courier IMAP & POP3
					$this->addDomainTraffic($matches[1], (int) $matches[2] + (int) $matches[3], $timestamp);
				}
			}
		}
		fclose($file_handle);
		return true;
	}

	/**
	 * _addDomainTraffic
	 * adds the traffic to the domain array if we own the domain
	 *
	 * @param
	 *        	string domain
	 * @param
	 *        	int traffic
	 */
	private function addDomainTraffic($domain, $traffic, $timestamp)
	{
		$date = date("Y-m-d", $timestamp);
		if (in_array($domain, $this->myDomains)) {
			if (array_key_exists($domain, $this->domainTraffic) && array_key_exists($date, $this->domainTraffic[$domain])) {
				$this->domainTraffic[$domain][$date] += (int) $traffic;
			} else {
				if (! array_key_exists($domain, $this->domainTraffic)) {
					$this->domainTraffic[$domain] = array();
				}
				$this->domainTraffic[$domain][$date] = (int) $traffic;
			}
		}
	}

	/**
	 * getLogTimestamp
	 *
	 * @param
	 *        	string line
	 *        	return int
	 */
	private function getLogTimestamp($line)
	{
		$matches = null;
		if (preg_match("/((?:[A-Z]{3}\s{1,2}\d{1,2}|\d{4}-\d{2}-\d{2}) \d{2}:\d{2}:\d{2})/i", $line, $matches)) {
			$timestamp = strtotime($matches[1]);
			if ($timestamp > ($this->startTime + 60 * 60 * 24)) {
				return strtotime($matches[1] . " -1 year");
			} else {
				return strtotime($matches[1]);
			}
		} else {
			return 0;
		}
	}

	/**
	 * getDomainTraffic
	 * returns the traffic of a given domain or 0 if the domain has no traffic
	 *
	 * @param
	 *        	string domain
	 *        	return array
	 */
	public function getDomainTraffic($domain)
	{
		if (array_key_exists($domain, $this->domainTraffic)) {
			return $this->domainTraffic[$domain];
		} else {
			return 0;
		}
	}
}
