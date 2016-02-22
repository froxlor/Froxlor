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
 * @author     Janos Muzsi <muzsij@hypernics.hu> (2016)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 * Based on https://github.com/amnuts/opcache-gui
 *
 */

define('AREA', 'admin');
require './lib/init.php';


if ($action == 'reset' &&
        function_exists('opcache_reset') &&
        $userinfo['change_serversettings'] == '1'
) {
    opcache_reset();
    $log->logAction(ADM_ACTION, LOG_INFO, "reseted OPcache");
    header('Location: ' . $linker->getLink(array('section' => 'opcacheinfo', 'page' => 'showinfo')));
    exit();
}

if (!function_exists('opcache_get_configuration')
) {
    standard_error($lng['error']['no_opcacheinfo']);
}

if ($page == 'showinfo'
) {
    
    $opcache_info = opcache_get_configuration();
    $opcache_status = opcache_get_status(false);
    $time = time();
    $log->logAction(ADM_ACTION, LOG_NOTICE, "viewed OPcache info");
    
    $runtimelines = '';
    if (isset($opcache_info['directives']) && is_array($opcache_info['directives'])) {
        foreach ($opcache_info['directives'] as $name => $value) {
            $linkname=  str_replace('_', '-', $name);
            if ($name=='opcache.optimization_level' && is_integer($value)) {
                $value='0x'.dechex($value);
            }
            if ($name=='opcache.memory_consumption' && is_integer($value) && $value%(1024*1024)==0) {
                $value=$value/(1024*1024);
            }
            if ($value===null || $value==='') {
                $value=$lng['opcacheinfo']['novalue'];
            }
            if ($value===true) {
                $value=$lng['opcacheinfo']['true'];
            }
            if ($value===false) {
                $value=$lng['opcacheinfo']['false'];
            }
            if (is_integer($value)) {
                $value=number_format($value,0,'.',' ');
            }
            $name=str_replace('_', ' ', $name);
            eval("\$runtimelines.=\"" . getTemplate("settings/opcacheinfo/runtime_line") . "\";");
        }
    }
    
    $cachehits=@$opcache_status['opcache_statistics']['hits'] ?: 0;
    $cachemiss=@$opcache_status['opcache_statistics']['misses'] ?: 0;
    $blacklistmiss=@$opcache_status['opcache_statistics']['blacklist_misses'] ?: 0;
    $cachetotal=$cachehits+$cachemiss+$blacklistmiss;
    
    $general=array(
        'version' => (isset($opcache_info['version']['opcache_product_name']) ? $opcache_info['version']['opcache_product_name'].' ' : '').$opcache_info['version']['version'],
        'phpversion' => phpversion(),
        'start_time'         => @$opcache_status['opcache_statistics']['start_time'] ? date('Y-m-d H:i:s',$opcache_status['opcache_statistics']['start_time']) : '',
        'last_restart_time'  => @$opcache_status['opcache_statistics']['last_restart_time'] ? date('Y-m-d H:i:s',$opcache_status['opcache_statistics']['last_restart_time']) : $lng['opcacheinfo']['never'],
        'oom_restarts' => number_format(@$opcache_status['opcache_statistics']['oom_restarts'] ?: 0,0,'.',' '),
        'hash_restarts' => number_format(@$opcache_status['opcache_statistics']['hash_restarts'] ?: 0,0,'.',' '),
        'manual_restarts' => number_format(@$opcache_status['opcache_statistics']['manual_restarts'] ?: 0,0,'.',' '),
        'status' => (@$opcache_status['restart_in_progress'] ? $lng['opcacheinfo']['restartinprogress'] :
            (@$opcache_status['restart_pending'] ? $lng['opcacheinfo']['restartpending'] :
            (@$opcache_status['cache_full'] ? $lng['opcacheinfo']['cachefull'] :
            (@$opcache_status['opcache_enabled'] ? $lng['opcacheinfo']['enabled'] : $lng['opcacheinfo']['novalue'])))),
        'cachedscripts' => number_format(@$opcache_status['opcache_statistics']['num_cached_scripts'] ?: 0,0,'.',' '),
        'cachehits' => number_format($cachehits,0,'.',' ') . ($cachetotal>0 ? sprintf(" (%.1f %%)", $cachehits/($cachetotal)*100) : ''),
        'cachemiss' => number_format($cachemiss,0,'.',' ') . ($cachetotal>0 ? sprintf(" (%.1f %%)", $cachemiss/($cachetotal)*100) : ''),
        'blacklistmiss' => number_format($blacklistmiss,0,'.',' ') . ($cachetotal>0 ? sprintf(" (%.1f %%)", $blacklistmiss/($cachetotal)*100) : ''),
    );
    
    $usedmem=@$opcache_status['memory_usage']['used_memory'] ?: 0;
    $usedmemstr=bsize($usedmem);
    $freemem=@$opcache_status['memory_usage']['free_memory'] ?: 0;
    $freememstr=bsize($freemem);
    $totalmem=$usedmem+$freemem;
    $wastedmem=@$opcache_status['memory_usage']['wasted_memory'] ?: 0;
    $wastedmemstr=bsize($wastedmem);
    if ($totalmem) {
        $memory=array(
            'total' => bsize($totalmem),
            'used' => $usedmemstr . ($totalmem>0 ? sprintf(" (%.1f %%)", $usedmem/($totalmem)*100) : ''),
            'free' => $freememstr . ($totalmem>0 ? sprintf(" (%.1f %%)", $freemem/($totalmem)*100) : ''),
            'wasted' => $wastedmemstr . ($totalmem>0 ? sprintf(" (%.1f %%)", $wastedmem/($totalmem)*100) : ''),
        );
    }
    
    if (isset($opcache_status['interned_strings_usage'])) {
        $usedstring=@$opcache_status['interned_strings_usage']['used_memory'] ?: 0;
        $usedstringstr=bsize($usedstring);
        $freestring=@$opcache_status['interned_strings_usage']['free_memory'] ?: 0;
        $freestringstr=bsize($freestring);
        $totalstring=$usedstring+$freestring;
        $stringbuffer=array(
            'total' => bsize($totalstring),
            'used' => $usedstringstr . ($totalstring>0 ? sprintf(" (%.1f %%)", $usedstring/$totalstring*100) : ''),
            'free' => $freestringstr . ($totalstring>0 ? sprintf(" (%.1f %%)", $freestring/$totalstring*100) : ''),
            'strcount' => number_format(@$opcache_status['interned_strings_usage']['number_of_strings'] ?: 0,0,'.',' '),
        );
    }

    $usedkey=@$opcache_status['opcache_statistics']['num_cached_keys'] ?: 0;
    $usedkeystr=number_format($usedkey,0,'.',' ');
    $totalkey=@$opcache_status['opcache_statistics']['max_cached_keys'] ?: 0;
    $wastedkey=$usedkey - (@$opcache_status['opcache_statistics']['num_cached_scripts'] ?: 0);
    if (isset($opcache_status['opcache_statistics'])) {
        $keystat=array(
            'total' => number_format($totalkey,0,'.',' '),
            'used' => $usedkeystr . ($totalkey>0 ? sprintf(" (%.1f %%)", $usedkey/($totalkey)*100) : ''),
            'wasted' => number_format($wastedkey,0,'.',' ') . ($totalkey>0 ? sprintf(" (%.1f %%)", $wastedkey/($totalkey)*100) : ''),
        );
    }
    
    $blacklistlines = '';
    if (isset($opcache_info['blacklist']) && is_array($opcache_info['blacklist'])) {
        foreach ($opcache_info['blacklist'] as $value) {
            eval("\$blacklistlines.=\"" . getTemplate("settings/opcacheinfo/blacklist_line") . "\";");
        }
    }
    
    eval("echo \"" . getTemplate("settings/opcacheinfo/showinfo") . "\";");
    
}

function bsize($s) {
    foreach (array('', 'K', 'M', 'G') as $i => $k) {
        if ($s < 1024)
            break;
        $s/=1024;
    }
    return sprintf("%5.1f %sBytes", $s, $k);
}
