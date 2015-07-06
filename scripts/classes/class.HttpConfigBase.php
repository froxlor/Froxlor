<?php
/***
 * Class HttpConfigBase
 *
 * Base class for all HTTP server configs
 *
 */
class HttpConfigBase {

	/**
	 * process special config as template, by substituting {VARIABLE} with the
	 * respective value.
	 *
	 * The following variables are known at the moment:
	 *
	 * {DOMAIN}         - domain name
	 * {IP}             - IP for this domain
	 * {PORT}           - Port for this domain
	 * {CUSTOMER}       - customer name
	 * {IS_SSL}         - '1' if domain/ip is ssl, '' otherwise
	 * {DOCROOT}        - document root for this domain
	 *
	 * @param $template
	 * @return string
	 */
	protected function processSpecialConfigTemplate($template, $ipandport, $domain) {
		$templateVars = array(
			'DOMAIN' => $domain['domain'],
			'CUSTOMER' => $domain['loginname'],
			'IP' => $ipandport['ip'],
			'PORT' => $ipandport['port'],
			'IS_SSL' => $domain['ssl'],
			'DOCROOT' => $domain['documentroot']
		);
		return replace_variables($template, $templateVars);
	}

} 