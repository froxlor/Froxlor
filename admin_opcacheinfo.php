<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @author     Janos Muzsi <muzsij@hypernics.hu>
 * @author     Andrew Collington <andy@amnuts.com>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 *
 * Based on https://github.com/amnuts/opcache-gui, which is
 * licensed under the MIT licence, which can be viewed
 * online at https://acollington.mit-license.org/
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\FroxlorLogger;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Response;
use Froxlor\UI\HTML;

if ($action == 'reset' && function_exists('opcache_reset') && $userinfo['change_serversettings'] == '1') {
	if ($_POST['send'] == 'send') {
		opcache_reset();
		$log->logAction(FroxlorLogger::ADM_ACTION, LOG_INFO, "reset OPcache");
		header('Location: ' . $linker->getLink([
				'section' => 'opcacheinfo',
				'page' => 'showinfo'
			]));
		exit();
	} else {
		HTML::askYesNo('cache_reallydelete', $filename, [
			'page' => $page,
			'action' => 'reset',
		], '', [
			'section' => 'opcacheinfo',
			'page' => 'showinfo'
		]);
	}
}

if (!function_exists('opcache_get_configuration')) {
	Response::standardError(lng('error.no_opcacheinfo'));
}

if ($page == 'showinfo' && $userinfo['change_serversettings'] == '1') {
	$time = time();
	$log->logAction(FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed OPcache info");

	$optimizationLevels = [
		1 << 0 => 'CSE, STRING construction',
		1 << 1 => 'Constant conversion and jumps',
		1 << 2 => '++, +=, series of jumps',
		1 << 3 => 'INIT_FCALL_BY_NAME -> DO_FCALL',
		1 << 4 => 'CFG based optimization',
		1 << 5 => 'DFA based optimization',
		1 << 6 => 'CALL GRAPH optimization',
		1 << 7 => 'SCCP (constant propagation)',
		1 << 8 => 'TMP VAR usage',
		1 << 9 => 'NOP removal',
		1 << 10 => 'Merge equal constants',
		1 << 11 => 'Adjust used stack',
		1 << 12 => 'Remove unused variables',
		1 << 13 => 'DCE (dead code elimination)',
		1 << 14 => '(unsafe) Collect constants',
		1 << 15 => 'Inline functions'
	];

	$jitModes = [
		[
			'flag' => 'CPU-specific optimization',
			'value' => [
				'Disable CPU-specific optimization',
				'Enable use of AVX, if the CPU supports it'
			]
		],
		[
			'flag' => 'Register allocation',
			'value' => [
				'Do not perform register allocation',
				'Perform block-local register allocation',
				'Perform global register allocation'
			]
		],
		[
			'flag' => 'Trigger',
			'value' => [
				'Compile all functions on script load',
				'Compile functions on first execution',
				'Profile functions on first request and compile the hottest functions afterwards',
				'Profile on the fly and compile hot functions',
				'Currently unused',
				'Use tracing JIT. Profile on the fly and compile traces for hot code segments'
			]
		],
		[
			'flag' => 'Optimization level',
			'value' => [
				'No JIT',
				'Minimal JIT (call standard VM handlers)',
				'Inline VM handlers',
				'Use type inference',
				'Use call graph',
				'Optimize whole script'
			]
		]
	];

	$jitModeMapping = [
		'tracing' => 1254,
		'on' => 1254,
		'function' => 1205
	];

	$status = opcache_get_status(false);
	$config = opcache_get_configuration();
	$missingConfig = array_diff_key(ini_get_all('zend opcache', false), $config['directives']);
	if (!empty($missingConfig)) {
		$config['directives'] = array_merge($config['directives'], $missingConfig);
	}

	$files = [];
	if (!empty($status['scripts'])) {
		uasort($status['scripts'], static function ($a, $b) {
			return $a['hits'] <=> $b['hits'];
		});
		foreach ($status['scripts'] as &$file) {
			$file['full_path'] = str_replace('\\', '/', $file['full_path']);
			$file['readable'] = [
				'hits' => number_format($file['hits']),
				'memory_consumption' => bsize($file['memory_consumption'])
			];
		}
		$files = array_values($status['scripts']);
	}

	if ($config['directives']['opcache.file_cache_only'] || !empty($status['file_cache_only'])) {
		$overview = false;
	} else {
		$status['opcache_statistics']['start_time'] = $status['opcache_statistics']['start_time'] ?? time();
		$status['opcache_statistics']['last_restart_time'] = $status['opcache_statistics']['last_restart_time'] ?? time();

		$overview = array_merge(
			$status['memory_usage'],
			$status['opcache_statistics'],
			[
				'total_memory' => $config['directives']['opcache.memory_consumption'],
				'used_memory_percentage' => round(100 * (
						($status['memory_usage']['used_memory'] + $status['memory_usage']['wasted_memory'])
						/ $config['directives']['opcache.memory_consumption']
					)),
				'hit_rate_percentage' => round($status['opcache_statistics']['opcache_hit_rate']),
				'used_key_percentage' => round(100 * ($status['opcache_statistics']['num_cached_keys']
						/ $status['opcache_statistics']['max_cached_keys']
					)),
				'wasted_percentage' => round($status['memory_usage']['current_wasted_percentage'], 2),
				'readable' => [
					'total_memory' => bsize($config['directives']['opcache.memory_consumption']),
					'used_memory' => bsize($status['memory_usage']['used_memory']),
					'free_memory' => bsize($status['memory_usage']['free_memory']),
					'wasted_memory' => bsize($status['memory_usage']['wasted_memory']),
					'num_cached_scripts' => number_format($status['opcache_statistics']['num_cached_scripts']),
					'hits' => number_format($status['opcache_statistics']['hits']),
					'misses' => number_format($status['opcache_statistics']['misses']),
					'blacklist_miss' => number_format($status['opcache_statistics']['blacklist_misses']),
					'num_cached_keys' => number_format($status['opcache_statistics']['num_cached_keys']),
					'max_cached_keys' => number_format($status['opcache_statistics']['max_cached_keys']),
					'interned' => null,
					'start_time' => (new DateTimeImmutable("@{$status['opcache_statistics']['start_time']}"))
						->setTimezone(new DateTimeZone(date_default_timezone_get()))
						->format('Y-m-d H:i:s'),
					'last_restart_time' => ($status['opcache_statistics']['last_restart_time'] == 0
						? 'never'
						: (new DateTimeImmutable("@{$status['opcache_statistics']['last_restart_time']}"))
							->setTimezone(new DateTimeZone(date_default_timezone_get()))
							->format('Y-m-d H:i:s')
					)
				]
			]
		);
	}

	$preload = [];
	if (!empty($status['preload_statistics']['scripts'])) {
		$preload = $status['preload_statistics']['scripts'];
		sort($preload, SORT_STRING);
		if ($overview) {
			$overview['preload_memory'] = $status['preload_statistics']['memory_consumption'];
			$overview['readable']['preload_memory'] = bsize($status['preload_statistics']['memory_consumption']);
		}
	}

	if (!empty($status['interned_strings_usage'])) {
		$overview['readable']['interned'] = [
			'buffer_size' => bsize($status['interned_strings_usage']['buffer_size']),
			'strings_used_memory' => bsize($status['interned_strings_usage']['used_memory']),
			'strings_free_memory' => bsize($status['interned_strings_usage']['free_memory']),
			'number_of_strings' => number_format($status['interned_strings_usage']['number_of_strings'])
		];
	}

	if ($overview && !empty($status['jit'])) {
		$overview['jit_buffer_used_percentage'] = ($status['jit']['buffer_size']
			? round(100 * (($status['jit']['buffer_size'] - $status['jit']['buffer_free']) / $status['jit']['buffer_size']))
			: 0
		);
		$overview['readable'] = array_merge($overview['readable'], [
			'jit_buffer_size' => bsize($status['jit']['buffer_size']),
			'jit_buffer_free' => bsize($status['jit']['buffer_free'])
		]);
	}

	$directives = [];
	ksort($config['directives']);
	foreach ($config['directives'] as $k => $v) {
		if (in_array($k, ['opcache.max_file_size', 'opcache.memory_consumption', 'opcache.jit_buffer_size']) && $v) {
			$v = bsize($v) . " ({$v})";
		} elseif ($k === 'opcache.optimization_level') {
			$levels = [];
			foreach ($optimizationLevels as $level => $info) {
				if ($level & $v) {
					$levels[] = "{$info} [{$level}]";
				}
			}
			$v = $levels ?: 'none';
		} elseif ($k === 'opcache.jit') {
			if ($v === '1') {
				$v = 'on';
			}
			if (isset($jitModeMapping[$v]) || is_numeric($v)) {
				$levels = [];
				foreach (str_split((string)($jitModeMapping[$v] ?? $v)) as $type => $level) {
					$levels[] = "{$level}: {$jitModes[$type]['value'][$level]} ({$jitModes[$type]['flag']})";
				}
				$v = [$v, $levels];
			} elseif (empty($v) || strtolower($v) === 'off') {
				$v = 'Off';
			}
		}
		$directives[] = [
			'k' => $k,
			'v' => $v
		];
	}

	$version = array_merge(
		$config['version'],
		[
			'php' => phpversion(),
			'server' => $_SERVER['SERVER_SOFTWARE'] ?: '',
			'host' => (function_exists('gethostname')
				? gethostname()
				: (php_uname('n')
					?: (empty($_SERVER['SERVER_NAME'])
						? $_SERVER['HOST_NAME']
						: $_SERVER['SERVER_NAME']
					)
				)
			)
		]
	);

	UI::view('settings/opcacheinfo.html.twig', [
		'opcacheinfo' => [
			'version' => $version,
			'overview' => $overview,
			'files' => $files,
			'preload' => $preload,
			'directives' => $directives,
			'blacklist' => $config['blacklist'],
			'functions' => get_extension_funcs('Zend OPcache')
		]
	]);
}

function bsize($size)
{
	$i = 0;
	$val = ['b', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	while (($size / 1024) > 1) {
		$size /= 1024;
		++$i;
	}
	return sprintf(
		'%.2f%s%s',
		$size,
		'',
		$val[$i]
	);
}
