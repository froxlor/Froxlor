<?php
if (! defined('AREA')) {
	header("Location: index.php");
	exit();
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
		'return_desc' => (isset($module['return']['desc']) && $module['return']['desc'] != "" ? $module['return']['desc'] : - 1),
		'params_list' => array(),
		'head' => $module['head'],
		'access' => isset($module['access']) ? $module['access'] : null
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
	
	$apihelp .= "<h2>" . $module . "</h2><hr /><br>";

	// output ALL the functions
	foreach ($functions as $function => $funcdata) {
		$apihelp .= "<div class=\"well\">";
		$apihelp .= "<h3>" . $module . " - ";
		// description
		if (strtoupper(substr($funcdata['head'], 0, 5)) == "@TODO") {
			$apihelp .= "<span class=\"red\">";
		}
		$apihelp .= $funcdata['head'];
		if (strtoupper(substr($funcdata['head'], 0, 5)) == "@TODO") {
			$apihelp .= "</span>";
		}
		$apihelp .= "</h3>";
		$apihelp .= "<b>Command" . "</b>&nbsp;";
		$apihelp .= "<span class=\"label\">" . $module . "." . $function . "</span><br>";
		if (isset($funcdata['access']['groups']) && ! empty($funcdata['access']['groups'])) {
			$apihelp .= "<br><b>Access:</b>&nbsp;";
			$apihelp .= $funcdata['access']['groups'] . "<br>";
		}

		// output ALL the params;
		if (count($funcdata['params_list']) > 0) {
			$parms = "<br><b>Parameter</b><br>";
			$parms .= "<table class=\"full hl\">";
			$parms .= "<thead><tr><th>Field</th><th>Type</th><th>Description</th></tr></thead>";
			$parms .= "<tbody>";
			// separate and format them
			foreach ($funcdata['params_list'] as $index => $param) {
				$parms .= "<tr><td><pre>";
				// check whether the parameter is optional
				if (! empty($param['desc']) && strtolower(substr(trim($param['desc']), 0, 8)) == "optional") {
					$parms .= "<i>" . $param['name'] . "</i>";
					$param['desc'] = substr(trim($param['desc']), 8);
					if (substr($param['desc'], 0, 1) == ',') {
						$param['desc'] = substr(trim($param['desc']), 1);
					}
				} else {
					$parms .= "<b>" . $param['name'] . "</b>";
				}
				$parms .= "</pre></td><td>" . (strtolower($param['type']) == 'unknown' ? "<span class=\"red\">unknown</span>" : $param['type']) . "</td>";
				$parms .= "<td>";
				if (! empty($param['desc'])) {
					$parms .= trim($param['desc']);
				}
				$parms .= "</td>";
				$parms .= "</tr>";
			}
			$parms .= "</tbody></table>";
			$apihelp .= $parms;
		}
		$apihelp .= "<br><b>Returns</b> " . ($funcdata['return_type'] == - 1 ? "<span class=\"red\">no-return-type</span>" : $funcdata['return_type']) . ($funcdata['return_desc'] == - 1 ? "" : " ".$funcdata['return_desc']);
		$apihelp .= "</div><br>";
	}
}

eval("echo \"" . getTemplate("apihelp/index", 1) . "\";");
