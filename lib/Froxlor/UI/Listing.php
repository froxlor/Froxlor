<?php
namespace Froxlor\UI;

use Froxlor\UI\Panel\UI;

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
 * @package    Listing
 *
 */
class Listing
{
    public static function format(Collection $collection, array $tabellisting): array
    {
        return [
            'title' => $tabellisting['title'],
            'icon' => $tabellisting['icon'],
            'table' => [
                'th' => self::generateTableHeadings($tabellisting),
                'tr' => self::generateTableRows($collection, $tabellisting),
            ],
            'pagination' => null, // TODO: write some logic
        ];
    }

    private static function generateTableHeadings(array $tabellisting): array
    {
        $heading = [];

        // Table headings for columns
        foreach ($tabellisting['visible_columns'] as $visible_column) {
            if (isset($tabellisting['columns'][$visible_column]['visible']) && !$tabellisting['columns'][$visible_column]['visible']) {
                continue;
            }

            $heading[] = $tabellisting['columns'][$visible_column]['label'];
        }

        // Table headings for actions
        if (isset($tabellisting['actions'])) {
            $heading[] = UI::getLng('panel.actions');
        }

        return $heading;
    }

    private static function generateTableRows(Collection $collection, array $tabellisting): array
    {
        $rows = [];
        $items = $collection->getData()['list'];

        // Create new row from item
        foreach ($items as $key => $item) {
            // Generate columns from item
            foreach ($tabellisting['visible_columns'] as $visible_column) {
                if (isset($tabellisting['columns'][$visible_column]['visible']) && !$tabellisting['columns'][$visible_column]['visible']) {
                    continue;
                }

                $format_callback = $tabellisting['columns'][$visible_column]['format_callback'] ?? null;
                $column = $tabellisting['columns'][$visible_column]['column'];
                $data = self::getMultiArrayFromString($item, $column);

                // TODO: contextual_class ...

                if ($format_callback) {
                    $rows[$key][] = call_user_func($format_callback, $data, $item);
                } else {
                    $rows[$key][] = $data;
                }
            }

            // Set all actions for row
            if (isset($tabellisting['actions'])) {
                $rows[$key]['action'] = [
                    'type' => 'actions',
                    'data' => $tabellisting['actions'],
                ];
            }
        }

        return $rows;
    }

    public static function getVisibleColumnsForListing($listing, $default_columns)
    {
        // Hier käme dann die Logik, die das aus der DB zieht ...
        // alternativ nimmt er die $default_columns, wenn kein Eintrag
        // in der DB definiert ist

        return $default_columns;
    }

    public static function getMultiArrayFromString($arr, $str)
    {
        foreach (explode('.', $str) as $key) {
            if (!array_key_exists($key, $arr)) {
                return null;
            }
            $arr = $arr[$key];
        }

        return $arr;
    }
}
