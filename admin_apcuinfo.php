<?php

/*
  +----------------------------------------------------------------------+
  | APC                                                                  |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006-2011 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Authors: Ralf Becker <beckerr@php.net>                               |
  |          Rasmus Lerdorf <rasmus@php.net>                             |
  |          Ilia Alshanetsky <ilia@prohost.org>                         |
  +----------------------------------------------------------------------+

   All other licensing and usage conditions are those of the PHP Group.

   Based on https://github.com/krakjoe/apcu/blob/master/apc.php
   Implemented into Froxlor: Janos Muzsi <muzsij@hypernics.hu>

 */

define('AREA', 'admin');
require './lib/init.php';


$horizontal_bar_size = 950; // 1280px window width

if ($action == 'delete' &&
        function_exists('apcu_clear_cache') &&
        $userinfo['change_serversettings'] == '1'
) {
    apcu_clear_cache();
    $log->logAction(ADM_ACTION, LOG_INFO, "cleared APCu cache");
    header('Location: ' . $linker->getLink(array('section' => 'apcuinfo', 'page' => 'showinfo')));
    exit();
}

if (!function_exists('apcu_cache_info') ||
        !function_exists('apcu_sma_info')
) {
    standard_error($lng['error']['no_apcuinfo']);
}

if ($page == 'showinfo'
) {
    $cache = apcu_cache_info();
    $mem = apcu_sma_info();
    $time = time();
    $log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_apcuinfo");

    $passtime = $time - $cache['start_time'] > 0 ? $time - $cache['start_time'] : 1; // zero division
    $mem_size = $mem['num_seg'] * $mem['seg_size'];
    $mem_avail = $mem['avail_mem'];
    $mem_used = $mem_size - $mem_avail;
    $seg_size = bsize($mem['seg_size']);
    $sharedmem = sprintf($lng['apcuinfo']['sharedmemval'], $mem['num_seg'], $seg_size, $cache['memory_type']);
    $req_rate_user = sprintf("%.2f", $cache['num_hits'] ? (($cache['num_hits'] + $cache['num_misses']) / $passtime) : 0);
    $hit_rate_user = sprintf("%.2f", $cache['num_hits'] ? (($cache['num_hits']) / $passtime) : 0);
    $miss_rate_user = sprintf("%.2f", $cache['num_misses'] ? (($cache['num_misses']) / $passtime) : 0);
    $insert_rate_user = sprintf("%.2f", $cache['num_inserts'] ? (($cache['num_inserts']) / $passtime) : 0);
    $apcversion = phpversion('apcu');
    $phpversion = phpversion();
    $number_vars = $cache['num_entries'];
    $starttime = date('Y-m-d H:i:s', $cache['start_time']);
    $uptime_duration = duration($cache['start_time']);
    $size_vars = bsize($cache['mem_size']);

    // check for possible empty values that are used in the templates
    if (!isset($cache['file_upload_progress'])) {
        $cache['file_upload_progress'] = $lng['logger']['unknown'];
    }

    if (!isset($cache['num_expunges'])) {
        $cache['num_expunges'] = $lng['logger']['unknown'];
    }

    $runtimelines = '';
    foreach (ini_get_all('apcu') as $name => $v) {
        $value = $v['local_value'];
        eval("\$runtimelines.=\"" . getTemplate("settings/apcuinfo/runtime_line") . "\";");
    }

    $freemem = bsize($mem_avail) . sprintf(" (%.1f%%)", $mem_avail * 100 / $mem_size);
    $usedmem = bsize($mem_used) . sprintf(" (%.1f%%)", $mem_used * 100 / $mem_size);
    $hits = $cache['num_hits'] . @sprintf(" (%.1f%%)", $cache['num_hits'] * 100 / ($cache['num_hits'] + $cache['num_misses']));
    $misses = $cache['num_misses'] . @sprintf(" (%.1f%%)", $cache['num_misses'] * 100 / ($cache['num_hits'] + $cache['num_misses']));

    // Fragementation: (freeseg - 1) / total_seg
    $nseg = $freeseg = $fragsize = $freetotal = 0;
    for ($i = 0; $i < $mem['num_seg']; $i++) {
        $ptr = 0;
        foreach ($mem['block_lists'][$i] as $block) {
            if ($block['offset'] != $ptr) {
                ++$nseg;
            }
            $ptr = $block['offset'] + $block['size'];
            /* Only consider blocks <5M for the fragmentation % */
            if ($block['size'] < (5 * 1024 * 1024))
                $fragsize+=$block['size'];
            $freetotal+=$block['size'];
        }
        $freeseg += count($mem['block_lists'][$i]);
    }

    if ($freeseg > 1) {
        $frag = sprintf("%.2f%% (%s out of %s in %d fragments)", ($fragsize / $freetotal) * 100, bsize($fragsize), bsize($freetotal), $freeseg);
    } else {
        $frag = "0%";
    }

    foreach (ini_get_all('apcu') as $name => $v) {
        $value = $v['local_value'];
    }

    $img_src1 = '';
    $img_src2 = '';
    $img_src3 = '';
    if (graphics_avail()) {
        $img_src = $linker->getLink(array('section' => 'apcuinfo', 'page' => 'img1', 'action' => mt_rand(0, 1000000)));
        eval("\$img_src1=\"" . getTemplate("settings/apcuinfo/img_line") . "\";");
        $img_src = $linker->getLink(array('section' => 'apcuinfo', 'page' => 'img2', 'action' => mt_rand(0, 1000000)));
        eval("\$img_src2=\"" . getTemplate("settings/apcuinfo/img_line") . "\";");
        $img_src = $linker->getLink(array('section' => 'apcuinfo', 'page' => 'img3', 'action' => mt_rand(0, 1000000)));
        eval("\$img_src3=\"" . getTemplate("settings/apcuinfo/img_line") . "\";");
    }

    eval("echo \"" . getTemplate("settings/apcuinfo/showinfo") . "\";");
    
} elseif ($page == 'img1'
) {

    $mem = apcu_sma_info();

    $size = 460;
    $image = imagecreate($size + 5, $size + 5);

    $col_white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
    $col_red = imagecolorallocate($image, 0xD0, 0x60, 0x30);
    $col_green = imagecolorallocate($image, 0x60, 0xF0, 0x60);
    $col_black = imagecolorallocate($image, 0, 0, 0);

    imagecolortransparent($image, $col_white);

    $s = $mem['num_seg'] * $mem['seg_size'];
    $a = $mem['avail_mem'];
    $x = $y = $size / 2;
    $fuzz = 0.000001;

    // This block of code creates the pie chart.  It is a lot more complex than you
    // would expect because we try to visualize any memory fragmentation as well.
    $angle_from = 0;
    $string_placement = array();
    for ($i = 0; $i < $mem['num_seg']; $i++) {
        $ptr = 0;
        $free = $mem['block_lists'][$i];
        uasort($free, 'block_sort');
        foreach ($free as $block) {
            if ($block['offset'] != $ptr) {       // Used block
                $angle_to = $angle_from + ($block['offset'] - $ptr) / $s;
                if (($angle_to + $fuzz) > 1)
                    $angle_to = 1;
                if (($angle_to * 360) - ($angle_from * 360) >= 1) {
                    fill_arc($image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_red);
                    if (($angle_to - $angle_from) > 0.05) {
                        array_push($string_placement, array($angle_from, $angle_to));
                    }
                }
                $angle_from = $angle_to;
            }
            $angle_to = $angle_from + ($block['size']) / $s;
            if (($angle_to + $fuzz) > 1)
                $angle_to = 1;
            if (($angle_to * 360) - ($angle_from * 360) >= 1) {
                fill_arc($image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_green);
                if (($angle_to - $angle_from) > 0.05) {
                    array_push($string_placement, array($angle_from, $angle_to));
                }
            }
            $angle_from = $angle_to;
            $ptr = $block['offset'] + $block['size'];
        }
        if ($ptr < $mem['seg_size']) { // memory at the end
            $angle_to = $angle_from + ($mem['seg_size'] - $ptr) / $s;
            if (($angle_to + $fuzz) > 1)
                $angle_to = 1;
            fill_arc($image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_red);
            if (($angle_to - $angle_from) > 0.05) {
                array_push($string_placement, array($angle_from, $angle_to));
            }
        }
    }
    foreach ($string_placement as $angle) {
        text_arc($image, $x, $y, $size, $angle[0] * 360, $angle[1] * 360, $col_black, bsize($s * ($angle[1] - $angle[0])));
    }

    header("Content-type: image/png");
    imagepng($image);
    exit;
} elseif ($page == 'img2'
) {

    $cache = apcu_cache_info();

    $size = $horizontal_bar_size;
    $image = imagecreate($size + 5, 140);

    $col_white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
    $col_red = imagecolorallocate($image, 0xD0, 0x60, 0x30);
    $col_green = imagecolorallocate($image, 0x60, 0xF0, 0x60);
    $col_black = imagecolorallocate($image, 0, 0, 0);

    imagecolortransparent($image, $col_white);

    $s = $cache['num_hits'] + $cache['num_misses'];
    $a = $cache['num_hits'];

    fill_box($image, 1, 10, $s ? ($a * ($size - 21) / $s) : $size, 50, $col_black, $col_green/* , sprintf("%.1f%%", $s ? $cache['num_hits'] * 100 / $s : 0) */);
    fill_box($image, 1, 80, $s ? max(4, ($s - $a) * ($size - 21) / $s) : $size, 50, $col_black, $col_red/* , sprintf("%.1f%%", $s ? $cache['num_misses'] * 100 / $s : 0) */);

    header("Content-type: image/png");
    imagepng($image);
    exit;
} elseif ($page == 'img3'
) {

    $mem = apcu_sma_info();

    $size = $horizontal_bar_size;
    $image = imagecreate($size, 70);

    $col_white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
    $col_red = imagecolorallocate($image, 0xD0, 0x60, 0x30);
    $col_green = imagecolorallocate($image, 0x60, 0xF0, 0x60);
    $col_black = imagecolorallocate($image, 0, 0, 0);

    imagecolortransparent($image, $col_white);

    $s = $mem['num_seg'] * $mem['seg_size'];
    $a = $mem['avail_mem'];
    $x = 10;
    $y = 0;

    // This block of code creates the bar chart.  It is a lot more complex than you
    // would expect because we try to visualize any memory fragmentation as well.
    for ($i = 0; $i < $mem['num_seg']; $i++) {
        $ptr = 0;
        $free = $mem['block_lists'][$i];
        uasort($free, 'block_sort');
        foreach ($free as $block) {
            if ($block['offset'] != $ptr) {       // Used block
                $h = ($size - 5) * ($block['offset'] - $ptr) / $s;
                if ($h > 0) {
                    fill_box($image, $y, $x, $h, 50, $col_black, $col_red);
                }
                $y+=$h;
            }
            $h = ($size - 5) * ($block['size']) / $s;
            if ($h > 0) {
                fill_box($image, $y, $x, $h, 50, $col_black, $col_green);
            }
            $y+=$h;
            $ptr = $block['offset'] + $block['size'];
        }
        if ($ptr < $mem['seg_size']) { // memory at the end
            $h = ($size - 5) * ($mem['seg_size'] - $ptr) / $s;
            if ($h > 0) {
                fill_box($image, $y, $x, $h, 50, $col_black, $col_red, bsize($mem['seg_size'] - $ptr), $j++);
            }
        }
    }

    header("Content-type: image/png");
    imagepng($image);
    exit;
}

function graphics_avail() {
    return extension_loaded('gd');
}

// pretty printer for byte values
//
function bsize($s) {
    foreach (array('', 'K', 'M', 'G') as $i => $k) {
        if ($s < 1024)
            break;
        $s/=1024;
    }
    return sprintf("%5.1f %sBytes", $s, $k);
}

function duration($ts) {
    global $time;
    $years = (int) ((($time - $ts) / (7 * 86400)) / 52.177457);
    $rem = (int) (($time - $ts) - ($years * 52.177457 * 7 * 86400));
    $weeks = (int) (($rem) / (7 * 86400));
    $days = (int) (($rem) / 86400) - $weeks * 7;
    $hours = (int) (($rem) / 3600) - $days * 24 - $weeks * 7 * 24;
    $mins = (int) (($rem) / 60) - $hours * 60 - $days * 24 * 60 - $weeks * 7 * 24 * 60;
    $str = '';
    if ($years == 1)
        $str .= "$years year, ";
    if ($years > 1)
        $str .= "$years years, ";
    if ($weeks == 1)
        $str .= "$weeks week, ";
    if ($weeks > 1)
        $str .= "$weeks weeks, ";
    if ($days == 1)
        $str .= "$days day,";
    if ($days > 1)
        $str .= "$days days,";
    if ($hours == 1)
        $str .= " $hours hour and";
    if ($hours > 1)
        $str .= " $hours hours and";
    if ($mins == 1)
        $str .= " 1 minute";
    else
        $str .= " $mins minutes";
    return $str;
}

function block_sort($array1, $array2) {
    if ($array1['offset'] > $array2['offset']) {
        return 1;
    } else {
        return -1;
    }
}

function fill_arc($im, $centerX, $centerY, $diameter, $start, $end, $color1, $color2, $text = '', $placeindex = 0) {
    $r = $diameter / 2;
    $w = deg2rad((360 + $start + ($end - $start) / 2) % 360);


    if (function_exists("imagefilledarc")) {
        // exists only if GD 2.0.1 is available
        imagefilledarc($im, $centerX + 1, $centerY + 1, $diameter, $diameter, $start, $end, $color1, IMG_ARC_PIE);
        imagefilledarc($im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color2, IMG_ARC_PIE);
        imagefilledarc($im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color1, IMG_ARC_NOFILL | IMG_ARC_EDGED);
    } else {
        imagearc($im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color2);
        imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($start)) * $r, $centerY + sin(deg2rad($start)) * $r, $color2);
        imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($start + 1)) * $r, $centerY + sin(deg2rad($start)) * $r, $color2);
        imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($end - 1)) * $r, $centerY + sin(deg2rad($end)) * $r, $color2);
        imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($end)) * $r, $centerY + sin(deg2rad($end)) * $r, $color2);
        imagefill($im, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $color2);
    }
    if ($text) {
        if ($placeindex > 0) {
            imageline($im, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $diameter, $placeindex * 12, $color1);
            imagestring($im, 4, $diameter, $placeindex * 12, $text, $color1);
        } else {
            imagestring($im, 4, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $text, $color1);
        }
    }
}

function text_arc($im, $centerX, $centerY, $diameter, $start, $end, $color1, $text, $placeindex = 0) {
    $r = $diameter / 2;
    $w = deg2rad((360 + $start + ($end - $start) / 2) % 360);

    if ($placeindex > 0) {
        imageline($im, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $diameter, $placeindex * 12, $color1);
        imagestring($im, 4, $diameter, $placeindex * 12, $text, $color1);
    } else {
        imagestring($im, 4, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $text, $color1);
    }
}

function fill_box($im, $x, $y, $w, $h, $color1, $color2, $text = '', $placeindex = '') {
    global $col_black;
    $x1 = $x + $w - 1;
    $y1 = $y + $h - 1;

    imagerectangle($im, $x, $y1, $x1 + 1, $y + 1, $col_black);
    if ($y1 > $y)
        imagefilledrectangle($im, $x, $y, $x1, $y1, $color2);
    else
        imagefilledrectangle($im, $x, $y1, $x1, $y, $color2);
    imagerectangle($im, $x, $y1, $x1, $y, $color1);
    if ($text) {
        if ($placeindex > 0) {

            if ($placeindex < 16) {
                $px = 5;
                $py = $placeindex * 12 + 6;
                imagefilledrectangle($im, $px + 90, $py + 3, $px + 90 - 4, $py - 3, $color2);
                imageline($im, $x, $y + $h / 2, $px + 90, $py, $color2);
                imagestring($im, 2, $px, $py - 6, $text, $color1);
            } else {
                if ($placeindex < 31) {
                    $px = $x + 40 * 2;
                    $py = ($placeindex - 15) * 12 + 6;
                } else {
                    $px = $x + 40 * 2 + 100 * intval(($placeindex - 15) / 15);
                    $py = ($placeindex % 15) * 12 + 6;
                }
                imagefilledrectangle($im, $px, $py + 3, $px - 4, $py - 3, $color2);
                imageline($im, $x + $w, $y + $h / 2, $px, $py, $color2);
                imagestring($im, 2, $px + 2, $py - 6, $text, $color1);
            }
        } else {
            imagestring($im, 4, $x + 5, $y1 - 16, $text, $color1);
        }
    }
}
