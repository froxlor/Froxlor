<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @since      0.9.33
 *
 */

/**
 * Class DomainBulkAction to mass-import domains for a given customer
 *
 * @author Michael Kaufmann (d00p) <d00p@froxlor.org>
 *        
 */
class DomainBulkAction
{

    /**
     * complete path including filename of file to be imported
     *
     * @var string
     */
    private $_impFile = null;

    /**
     * customer id of the user the domains are being added to
     *
     * @var int
     */
    private $_custId = null;

    /**
     * array of customer data read from the database
     *
     * @var array
     */
    private $_custData = null;

    /**
     * array of already known domains from the database
     *
     * @var array
     */
    private $_knownDomains = null;

    /**
     * array of known ip/port combinations
     *
     * @var array
     */
    private $_knownIpPort = null;

    /**
     * array of known IP's to check against
     *
     * @var array
     */
    private $_knownIpPortChk = null;

    /**
     * array of fields to import to panel_domains
     *
     * @var array
     */
    private $_required_fields = array (
/*  1 */	'domain',
/*  2 */	'documentroot',
/*  3 */    'aliasdomain',
/*  4 */	'isbinddomain',
/*  5 */	'isemaildomain',
/*  6 */	'email_only',
/*  7 */	'iswildcarddomain',
/*  8 */	'subcanemaildomain',
/*  9 */	'caneditdomain',
/* 10 */    'zonefile',
/* 11 */	'wwwserveralias',
/* 12 */    'openbasedir',
/* 13 */    'speciallogfile',
/* 14 */	'specialsettings',
/* 15 */	'ssl_redirect',
/* 16 */    'use_ssl',
/* 17 */	'registration_date',
/* 18 */	'ips',
	    /* automatically added */
		'adminid',
        'customerid',
        'add_date'
    );

    /**
     * prepared statements for each domain
     *
     * @var PDOStatement
     */
    private $_ins_stmt = null;

    private $_ipp_ins_stmt = null;

    /**
     * class constructor, optionally sets file and customer-id
     *
     * @param string $import_file            
     * @param int $customer_id            
     *
     * @return object DomainBulkAction instance
     */
    public function __construct($import_file = null, $customer_id = 0)
    {
        if (! empty($import_file)) {
            $this->_impFile = makeCorrectFile($import_file);
        }
        $this->_custId = $customer_id;
    }

    /**
     * import the parsed import file data with an optional separator other then semicolon
     * and offset (maybe for header-line in csv or similar)
     *
     * @param string $separator            
     * @param int $offset            
     *
     * @return array 'all' => amount of records processed, 'imported' => number of imported records
     */
    public function doImport($separator = ";", $offset = 0)
    {
        
        // get the admins userinfo to check for domains_used, etc.
        global $userinfo;
        
        if ($userinfo['domains'] == "-1") {
            $dom_unlimited = true;
        } else {
            $dom_unlimited = false;
        }
        
        $domains_used = (int) $userinfo['domains_used'];
        $domains_avail = (int) $userinfo['domains'];
        
        if (empty($separator) || strlen($separator) != 1) {
            throw new Exception("Invalid separator specified: '" . $separator . "'");
        }
        
        if (! is_int($offset) || $offset < 0) {
            throw new Exception("Invalid offset specified");
        }
        
        if ($this->_custId <= 0) {
            throw new Exception("Invalid customer selected");
        }
        
        $this->_readCustomerData();
        
        if (is_null($this->_custData)) {
            throw new Exception("Failed to read customer data");
        }
        
        $this->_readIpPortData();
        $this->_readDomainData();
        
        try {
            $domain_array = $this->_parseImportFile($separator);
        } catch (Exception $e) {
            throw $e;
        }
        
        if (count($domain_array) <= 0) {
            throw new Exception("No domains were read from the file.");
        }
        
        // preapre insert statement as it is used a few times
        $this->_ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_DOMAINS . "` SET
				`domain` = :domain,
				`adminid` = :adminid,
				`customerid` = :customerid,
				`documentroot` = :documentroot,
                `aliasdomain` = :aliasdomain,
				`isbinddomain` = :isbinddomain,
				`isemaildomain` = :isemaildomain,
				`email_only` = :email_only,
				`iswildcarddomain` = :iswildcarddomain,
				`subcanemaildomain` = :subcanemaildomain,
				`caneditdomain` = :caneditdomain,
                `zonefile` = :zonefile,
				`wwwserveralias` = :wwwserveralias,
                `openbasedir` = :openbasedir,
                `speciallogfile` = :speciallogfile,
				`specialsettings` = :specialsettings,
				`ssl_redirect` = :ssl_redirect,
				`registration_date` = :registration_date,
				`add_date` = :add_date
		");
        
        // prepare insert statement for ip/port <> domain
        $this->_ipp_ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_DOMAINTOIP . "` SET
				`id_domain` = :domid,
				`id_ipandports` = :ipid
		");
        
        $global_counter = 0;
        $import_counter = 0;
        $note = '';
        foreach ($domain_array as $idx => $dom) {
            if ($idx >= $offset) {
                if ($dom_unlimited || (! $dom_unlimited && $domains_used < $domains_avail)) {
                    $ins_id = $this->_addSingleDomainToDatabase($dom);
                    if ($ins_id !== false) {
                        $import_counter ++;
                        $domains_used ++;
                    }
                } else {
                    $note = 'You have reached your maximum allocation of domains (' . $domains_avail . ').';
                    break;
                }
            }
            $global_counter ++;
        }
        
        return array(
            'all' => $global_counter,
            'imported' => $import_counter,
            'notice' => $note
        );
    }

    /**
     * setter for import-file
     *
     * @param string $import_file            
     *
     * @return void
     */
    public function setImportFile($import_file = null)
    {
        $this->_impFile = makeCorrectFile($import_file);
    }

    /**
     * setter for customer-id
     *
     * @param int $customer_id            
     *
     * @return void
     */
    public function setCustomer($customer_id = 0)
    {
        $this->_custId = $customer_id;
    }

    /**
     * adds a single domain to the database using the given array
     *
     * @param array $domain_data            
     *
     * @return int last-inserted id or false on error
     */
    private function _addSingleDomainToDatabase($domain_data = array())
    {
        
        // format domain
        $idna_convert = new idna_convert_wrapper();
        $domain_data['domain'] = $idna_convert->encode(preg_replace(array(
            '/\:(\d)+$/',
            '/^https?\:\/\//'
        ), '', $domain_data['domain']));
        
        // check if it is a valid domain
        if (! validateDomain($domain_data['domain'])) {
            return false;
        }
        
        // no system-hostname can be added
        if ($domain_data['domain'] == Settings::Get('system.hostname')) {
            return false;
        }
        
        // no existing domains can be imported
        if (in_array($domain_data['domain'], $this->_knownDomains)) {
            return false;
        }
        
        // check for alias-domain
        if (! empty($domain_data['aliasdomain'])) {
            // format
            $domain_data['aliasdomain'] = $idna_convert->encode(preg_replace(array(
                '/\:(\d)+$/',
                '/^https?\:\/\//'
            ), '', $domain_data['aliasdomain']));
            // validate alias-domain
            if (! validateDomain($domain_data['aliasdomain'])) {
                // invalid-domain lol - skip to be sure we don't add anything weird
                return false;
            }
            // does the domain we want to be an alias of exists?
            if (! in_array($domain_data['aliasdomain'], $this->_knownDomains)) {
                // it does not - User should respect the order of import so if the domain
                // he wants to alias is also part of the import is ABOVE this one
                // - we'd better skip
                return false;
            }
        }
        
        // check for use_ssl and ssl_redirect
        if (!isset($domain_data['use_ssl']) || $domain_data['use_ssl'] == 1) {
            // if not set: default is whatever the system says
            // if set to 1: set to 0 if system has no ssl enabled
            $domain_data['use_ssl'] = (Settings::get('system.use_ssl') == 1 ? 1 : 0);
        }

        // use_ssl flag
        if ($domain_data['use_ssl'] != 1) {
            $domain_data['use_ssl'] = 0;
        }
        
        // ssl_redirect flag
        if ($domain_data['ssl_redirect'] != 1) {
            $domain_data['ssl_redirect'] = 0;
        }

        // if use_ssl is 0 ssl_redirect must be too (no ssl-ip => no ssl-redirect)
        if ($domain_data['use_ssl'] == 0 && $domain_data['ssl_redirect'] == 1) {
            $domain_data['ssl_redirect'] = 0;
        }
        
        // add to known domains
        $this->_knownDomains[] = $domain_data['domain'];
        
        // docroot (URL allowed, will lead to redirect)
        if (! preg_match('/^https?\:\/\//', $domain_data['documentroot'])) {
            $domain_data['documentroot'] = makeCorrectDir($this->_custData['documentroot'] . "/" . $domain_data['documentroot']);
        }
        
        // is bind domain?
        if (! isset($domain_data['isbinddomain'])) {
            $domain_data['isbinddomain'] = (Settings::Get('system.bind_enable') == '1') ? 1 : 0;
        } elseif ($domain_data['isbinddomain'] != 1) {
            $domain_data['isbinddomain'] = 0;
        }
        
        // zonefile
        if (!isset($domain_data['zonefile'])) {
            $domain_data['zonefile'] = "";
        } else {
            if (!empty($domain_data['zonefile']) && Settings::Get('system.bind_enable') == '1') {
                $domain_data['zonefile'] = makeCorrectFile($domain_data['zonefile']);
            } else {
                $domain_data['zonefile'] = "";
            }
        }

        // openbasedir flag
        if (! isset($domain_data['openbasedir'])) {
            $domain_data['openbasedir'] = 1;
        } elseif ($domain_data['openbasedir'] != 1) {
            $domain_data['openbasedir'] = 0;
        }

        // speciallogfile flag
        if (! isset($domain_data['speciallogfile'])) {
            $domain_data['speciallogfile'] = 0;
        } elseif ($domain_data['speciallogfile'] != 1) {
            $domain_data['speciallogfile'] = 0;
        }

        /*
         * automatically set values (not from the file)
         */
        // add date
        $domain_data['add_date'] = time();
        // set adminid
        $domain_data['adminid'] = (int)$this->_custData['adminid'];
        // set customerid
        $domain_data['customerid'] = (int)$this->_custId;
        
        // check for required fields
        foreach ($this->_required_fields as $rfld) {
            if (! isset($domain_data[$rfld])) {
                return false;
            }
        }
        
        // clean all fields that do not belong to the required fields
        $domain_data_tmp = $domain_data;
        foreach ($domain_data_tmp as $fld => $val) {
            if (! in_array($fld, $this->_required_fields)) {
                unset($domain_data[$fld]);
            }
        }
        
        // save iplist
        $iplist = $domain_data['ips'];
        $iplist_arr = array_unique(explode(",", $iplist));
        $knownIPsCheck = array_unique($this->_knownIpPortChk);
        // check whether we actually have at least one of the used IP's in our system
        $result_iplist = array_intersect($iplist_arr, $knownIPsCheck);
        // write back iplist
        $iplist = implode(",", $result_iplist);
        
        // don't need that for the domain-insert-statement
        unset($domain_data['ips']);
        
        // remember use_ssl value
        $use_ssl = (bool)$domain_data['use_ssl'];
        // don't need that for the domain-insert-statement
        unset($domain_data['use_ssl']);
        
        // finally ADD the domain to panel_domains
        Database::pexecute($this->_ins_stmt, $domain_data);
        
        // get the newly inserted domain-id
        $domain_id = Database::lastInsertId();
        
        // insert domain <-> ip/port reference
        if (empty($iplist)) {
            $iplist = Settings::Get('system.ipaddress');
        }
        
        // split ip-list and remove duplicates
        $iplist_arr = array_unique(explode(",", $iplist));
        foreach ($iplist_arr as $ip) {
            // if we know the ip, at all variants (different ports, ssl and non-ssl) of it!
            if (isset($this->_knownIpPort[$ip])) {
                foreach ($this->_knownIpPort[$ip] as $ipdata) {
                    // no ssl ip/ports should be used for this domain
                    if ($use_ssl == false && $ipdata['ssl'] == 1) {
                        continue;
                    }
                    // add domain->ip reference
                    Database::pexecute($this->_ipp_ins_stmt, array(
                        'domid' => $domain_id,
                        'ipid' => $ipdata['id']
                    ));
                }
            }
        }
        
        return $domain_id;
    }

    /**
     * reads in the csv import file and returns an array with
     * all the domains to be imported
     *
     * @param string $separator            
     *
     * @return array
     */
    private function _parseImportFile($separator = ";")
    {
        if (empty($this->_impFile)) {
            throw new Exception("No file was given for import");
        }
        
        if (! file_exists($this->_impFile)) {
            throw new Exception("The file '" . $this->_impFile . "' could not be found");
        }
        
        if (! is_readable($this->_impFile)) {
            throw new Exception("Unable to read file '" . $this->_impFile . "'");
        }
        
        $file_data = array();
        
        $fh = @fopen($this->_impFile, "r");
        if ($fh) {
            while (($line = fgets($fh)) !== false) {
                $tmp_arr = explode($separator, $line);
                $data_arr = array();
                foreach ($tmp_arr as $idx => $data) {
                    // don't include more fields than the ones we use
                    if ($idx > (count($this->_required_fields) - 4)) // off-by-one + 3 auto-values
                        break;
                    $data_arr[$this->_required_fields[$idx]] = $data;
                }
                $file_data[] = array_map("trim", $data_arr);
            }
        } else {
            throw new Exception("Unable to open file '" . $this->_impFile . "'");
        }
        fclose($fh);
        
        return $file_data;
    }

    /**
     * reads customer data from panel_customer by $_custId
     *
     * @return bool
     */
    private function _readCustomerData()
    {
        $cust_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `customerid` = :cid");
        $this->_custData = Database::pexecute_first($cust_stmt, array(
            'cid' => $this->_custId
        ));
        if (is_array($this->_custData) && isset($this->_custData['customerid']) && $this->_custData['customerid'] == $this->_custId) {
            return true;
        }
        $this->_custData = null;
        return false;
    }

    /**
     * reads domain data from panel_domain
     *
     * @return void
     */
    private function _readDomainData()
    {
        $knowndom_stmt = Database::prepare("SELECT `domain` FROM `" . TABLE_PANEL_DOMAINS . "` ORDER BY `domain` ASC");
        Database::pexecute($knowndom_stmt);
        $this->_knownDomains = array();
        while ($dom = $knowndom_stmt->fetch()) {
            $this->_knownDomains[] = $dom['domain'];
        }
    }

    /**
     * reads ip/port data from panel_ipsandports
     *
     * @return void
     */
    private function _readIpPortData()
    {
        $knownip_stmt = Database::prepare("SELECT * FROM `" . TABLE_PANEL_IPSANDPORTS . "`");
        Database::pexecute($knownip_stmt);
        $this->_knownIpPort = array();
        while ($ipp = $knownip_stmt->fetch()) {
            $this->_knownIpPort[$ipp['ip']][] = $ipp;
            $this->_knownIpPortChk[] = $ipp['ip'];
        }
    }
}
