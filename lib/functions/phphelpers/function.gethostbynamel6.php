<?php

/**
 * ipv6 aware gethostbynamel function
 *
 * @param string $host
 * @param boolean $try_a default true
 * @return boolean|array
 */
function gethostbynamel6($host, $try_a = true)
{
	$dns6 = dns_get_record($host, DNS_AAAA);
	if ($try_a == true) {
		$dns4 = dns_get_record($host, DNS_A);
		$dns = array_merge($dns4, $dns6);
	} else {
		$dns = $dns6;
	}
	$ips = array();
	foreach ($dns as $record) {
		if ($record["type"] == "A") {
			$ips[] = $record["ip"];
		}
		if ($record["type"] == "AAAA") {
			$ips[] = $record["ipv6"];
		}
	}
	if (count($ips) < 1) {
		return false;
	} else {
		return $ips;
	}
}
