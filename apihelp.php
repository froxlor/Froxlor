<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit;
}

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Panel
 * @since 0.10.0
 *         
 */

// This file is being included in admin_index and customer_index
// and therefore does not need to require lib/init.php
	
try {
	$json_result = Froxlor::getLocal($userinfo)->listFunctions();
} catch (Exception $e) {
	dynamic_error($e->getMessage());
}
$result = json_decode($json_result, true)['data'];

// get response data
$m_arr = $result;

// initialize output-array
$output_arr = array();

// check every module
foreach ($m_arr as $module) {
	
	// initialize module array for sorting
	if (! isset($output_arr[$module['module']]) || ! is_array($output_arr[$module['module']])) {
		$output_arr[$module['module']] = array();
	}
	
	// set necessary data
	$output_arr[$module['module']][$module['function']] = array(
		'return_type' => (isset($module['return']['type']) && $module['return']['type'] != "" ? $module['return']['type'] : - 1),
		'params_list' => array(),
		'head' => $module['head']
	);
	
	if (isset($module['params']) && is_array($module['params'])) {
		foreach ($module['params'] as $param) {
			$output_arr[$module['module']][$module['function']]['params_list'][] = array(
				'type' => $param['type'],
				'name' => $param['parameter'],
				'desc' => $param['desc']
			);
		}
	}
}

// sort array
ksort($output_arr);

$apihelp = "";

// output ALL the modules
foreach ($output_arr as $module => $functions) {
	
	// sort by function
	ksort($functions);
	
	// output ALL the functions
	foreach ($functions as $function => $funcdata) {
		$apihelp .= "<blockquote>";
		$apihelp .= "<h3>" . ($funcdata['return_type'] == - 1 ? "<span class=\"red\">no-return-type</span>" : $funcdata['return_type']) . "&nbsp;";
		$apihelp .= "<b>" . $module . ".<span class=\"blue\">" . $function . "</span></b></h3>";
		// description
		if (strtoupper(substr($funcdata['head'], 0, 5)) == "@TODO")
			$apihelp .= "<span class=\"red\">";
		$apihelp .= $funcdata['head'];
		if (strtoupper(substr($funcdata['head'], 0, 5)) == "@TODO")
			$apihelp .= "</span>";
		// output ALL the params;
		if (count($funcdata['params_list']) > 0) {
			$parms = "<br><br><b>Parameters:</b><br><pre><ul>";
			// separate and format them
			foreach ($funcdata['params_list'] as $index => $param) {
				$parms .= "<li>";
				// check whether the parameter is optional
				if (! empty($param['desc']) && strtolower(substr(trim($param['desc']), 0, 8)) == "optional") {
					$parms .= "<i>optional</i>&nbsp;";
					$param['desc'] = substr(trim($param['desc']), 8);
					if (substr($param['desc'], 0, 1) == ',') {
						$param['desc'] = substr(trim($param['desc']), 1);
					}
				}
				$parms .= "<b>" . (strtolower($param['type']) == 'unknown' ? "<span class=\"red\">unknown</span>" : $param['type']) . "&nbsp;<span class=\"orange\">" . $param['name'] . "</span></b>";
				if (! empty($param['desc'])) {
					$parms .= "&nbsp;" . trim($param['desc']);
				}
				$parms .= "<li>";
			}
			$apihelp .= "</ul></pre>" . $parms;
		}
		$apihelp .= "</blockquote><br><br>";
	}
	$apihelp .= "<hr />";
}

eval("echo \"" . getTemplate("apihelp/index", 1) . "\";");
