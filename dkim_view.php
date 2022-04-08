<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit();
}

use Froxlor\Settings;
use Froxlor\Api\Commands\Domains as Domains;


if (Settings::Get('dkim.use_dkim') != '1') {
	\Froxlor\UI\Response::standard_error('dkim_notenabled');
	return;
}
$fields = array(
	'd.domain' => $lng['domains']['domainname']
);
try {
	// get total count
	$json_result = Domains::getLocal($userinfo)->listingCount();
	$result = json_decode($json_result, true)['data'];
	// initialize pagination and filtering
	$paging = new \Froxlor\UI\Pagination($userinfo, $fields, $result);
	// get list
	$params = $paging->getApiCommandParams();
	//$domain['dkim'];
	$json_result = Domains::getLocal($userinfo, $params)->listing();
} catch (Exception $e) {
	\Froxlor\UI\Response::dynamic_error($e->getMessage());
}
$result = json_decode($json_result, true)['data'];
$domains = $result['list'];

$sortcode = $paging->getHtmlSortCode($lng);
$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
$searchcode = $paging->getHtmlSearchCode($lng);
$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);

$domains_selectors = '';

foreach ($domains as $idx => $domain) {
	$domain_id = $domain['id'];
	$adminCustomerLink = "";
	if (AREA == 'admin' && $domain['id'] > 0) {
		if (! empty($domain['loginname'])) {
			$adminCustomerLink = '&nbsp;(<a href="' . $linker->getLink(array(
				'section' => 'customers',
				'page' => 'customers',
				'action' => 'su',
				'id' => $domain['customerid']
			)) . '" rel="external">' . $domain['loginname'] . '</a>)';
		}
	}

	try {
		$json_result = Domains::getLocal($userinfo, array(
			'id' => $domain_id
		))->getDKIMSelectors();
	} catch (Exception $e) {
		\Froxlor\UI\Response::dynamic_error($e->getMessage());
	}
	
	$selectors = json_decode($json_result, true)['data'];

	if (!empty($selectors)) {
		foreach ($selectors as $selector) {
			$selector['domain'] = $idna_convert->decode($selector['domain']);
			$row = \Froxlor\PhpHelper::htmlentitiesArray($selector);
			eval("\$domains_selectors.=\"" . \Froxlor\UI\Template::getTemplate("dkim/dkim_selector", true) . "\";");
		}
	} else {
		$selectorEmpty = array(
			'domain' => $idna_convert->decode($domain['domain'])
		);
		$row = \Froxlor\PhpHelper::htmlentitiesArray($selectorEmpty);
		eval("\$domains_selectors.=\"" . \Froxlor\UI\Template::getTemplate("dkim/dkim_selectors_empty", true) . "\";");
	}
}

eval("echo \"" . \Froxlor\UI\Template::getTemplate("dkim/dkim_list", true) . "\";");