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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Tabellisting
 *
 */

return [
    'customer_list' => [
        'title' => $lng['admin']['customers'],
        'icon' => 'fa-solid fa-user',
        'columns' => [
            'loginname' => [
                'title' => $lng['login']['username']
            ],
        ],
        'visible_columns' => getVisibleColumnsForListing('admin_list', [
            'loginname',
        ]),
    ]
];

// Das müsste dann irgendwie als Klasse ausgelagert werden
function getVisibleColumnsForListing($listing, $default_columns)
{
    // Hier käme dann die Logik, die das aus der DB zieht ...
    // alternativ nimmt er die $default_columns, wenn kein Eintrag
    // in der DB definiert ist

    return $default_columns;
}
