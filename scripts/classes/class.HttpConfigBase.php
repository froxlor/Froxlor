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
	 * {IS_SSL}         - evaluates to 'ssl' if domain/ip is ssl, otherwise it is an empty string
	 * {DOCROOT}        - document root for this domain
	 *
	 * @param $template
	 * @return string
	 */
	protected function processSpecialConfigTemplate($template, $domain, $ip, $port, $is_ssl_vhost) {
		$templateVars = array(
			'DOMAIN' => $domain['domain'],
			'CUSTOMER' => $domain['loginname'],
			'IP' => $ip,
			'PORT' => $port,
			'SCHEME' => ($is_ssl_vhost)?'https':'http',
			'DOCROOT' => $domain['documentroot']
		);
		return replace_variables($template, $templateVars);
	}

} 