<?php declare(strict_types=1);
/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2016-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 *
 * @param mixed $domain
 */
function generateDkimEntries($domain)
{
    $zone_dkim = array();

    if (Settings::Get('dkim.use_dkim') === '1' && $domain['dkim'] === '1' && $domain['dkim_pubkey'] !== '') {
        // start
        $dkim_txt = 'v=DKIM1;';

        // algorithm
        $algorithm = explode(',', Settings::Get('dkim.dkim_algorithm'));
        $alg = '';
        foreach ($algorithm as $a) {
            if ($a === 'all') {
                break;
            }
            $alg .= $a . ':';
        }

        if ($alg !== '') {
            $alg = substr($alg, 0, - 1);
            $dkim_txt .= 'h=' . $alg . ';';
        }

        // notes
        if (trim(Settings::Get('dkim.dkim_notes') !== '')) {
            $dkim_txt .= 'n=' . trim(Settings::Get('dkim.dkim_notes')) . ';';
        }

        // key
        $dkim_txt .= 'k=rsa;p=' . trim(preg_replace('/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace("\n", '', $domain['dkim_pubkey']))) . ';';

        // service-type
        if (Settings::Get('dkim.dkim_servicetype') === '1') {
            $dkim_txt .= 's=email;';
        }

        // end-part
        $dkim_txt .= 't=s';

        // dkim-entry
        $zone_dkim[] = $dkim_txt;

        // adsp-entry
        if (Settings::Get('dkim.dkim_add_adsp') === '1') {
            $adsp = '"dkim=';
            switch ((int) Settings::Get('dkim.dkim_add_adsppolicy')) {
                case 0:
                    $adsp .= 'unknown"';
                    break;
                case 1:
                    $adsp .= 'all"';
                    break;
                case 2:
                    $adsp .= 'discardable"';
                    break;
            }
            $zone_dkim[] = $adsp;
        }
    }

    return $zone_dkim;
}
