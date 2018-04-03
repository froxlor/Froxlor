<?php declare(strict_types=1);
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
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 */

return array(
    'category_edit' => array(
        'title' => $lng['ticket']['ticket_editcateory'],
        'image' => 'icons/category_edit.png',
        'sections' => array(
            'section_a' => array(
                'title' => $lng['ticket']['ticket_editcateory'],
                'image' => 'icons/category_edit.png',
                'fields' => array(
                    'category' => array(
                        'label' => $lng['ticket']['category'],
                        'type' => 'text',
                        'maxlength' => 50,
                        'value' => $row['name'],
                    ),
                    'logicalorder' => array(
                        'label' => $lng['ticket']['logicalorder'],
                        'desc' => $lng['ticket']['orderdesc'],
                        'type' => 'text',
                        'maxlength' => 3,
                        'value' => $row['logicalorder'],
                    ),
                ),
            ),
        ),
    ),
);
