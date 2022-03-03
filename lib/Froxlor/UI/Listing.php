<?php

namespace Froxlor\UI;

use Froxlor\UI\Panel\UI;
use Exception;

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
		$collection = $collection->get();

		return [
			'title' => $tabellisting['title'],
			'icon' => $tabellisting['icon'],
			'table' => [
				'th' => self::generateTableHeadings($tabellisting),
				'tr' => self::generateTableRows($collection['data']['list'], $tabellisting),
			],
			'pagination' => $collection['pagination'],
			'empty_msg' => $tabellisting['empty_msg'] ?? null
		];
	}

	public static function formatFromArray(array $collection, array $tabellisting): array
	{
		return [
			'title' => $tabellisting['title'],
			'icon' => $tabellisting['icon'],
			'table' => [
				'th' => self::generateTableHeadings($tabellisting),
				'tr' => self::generateTableRows($collection['data'], $tabellisting),
			],
			'pagination' => $collection['pagination'],
			'empty_msg' => $tabellisting['empty_msg'] ?? null
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

			$heading[$visible_column] = [
				'text' => $tabellisting['columns'][$visible_column]['label'],
				'class' => $tabellisting['columns'][$visible_column]['class'] ?? null,
			];
		}

		// Table headings for actions
		if (isset($tabellisting['actions'])) {
			$heading['actions'] = [
				'text' => UI::getLng('panel.options'),
				'class' => 'text-end',
			];
		}

		return $heading;
	}

	/**
	 * @throws Exception
	 */
	private static function generateTableRows(array $list, array $tabellisting): array
	{
		$rows = [];

		// Create new row from item
		foreach ($list as $row => $fields) {
			// Generate columns from item
			foreach ($tabellisting['visible_columns'] as $col => $visible_column) {
				// Continue if column is not visible
				if (isset($tabellisting['columns'][$visible_column]['visible']) && !$tabellisting['columns'][$visible_column]['visible']) {
					continue;
				}

				// Get data from filed if it is defined
				$field = $tabellisting['columns'][$visible_column]['field'] ?? null;
				$data = $field ? self::getMultiArrayFromString($fields, $field) : null;

				// Call user function for given column if defined or return data from field, otherwise throw exception
				$callback = $tabellisting['columns'][$visible_column]['callback'] ?? null;
				if ($callback) {
					$rows[$row]['td'][$col]['data'] = call_user_func($callback, ['data' => $data, 'fields' => $fields]);
				} elseif ($field) {
					$rows[$row]['td'][$col]['data'] = $data;
				} else {
					throw new Exception('The visible column "' . $visible_column . '" has neither a "callback" nor a "field" set.');
				}

				// Set class for table-row if defined
				$rows[$row]['td'][$col]['class'] = $tabellisting['columns'][$visible_column]['class'] ?? null;
			}

			// Set row classes from format_callback
			if (isset($tabellisting['format_callback'])) {
				$class = [];
				foreach ($tabellisting['format_callback'] as $format_callback) {
					$class[] = call_user_func($format_callback, ['fields' => $fields]);
				}
				$rows[$row]['class'] = implode(' ', $class);
			}

			// Set all actions for row
			if (isset($tabellisting['actions'])) {
				$actions = self::setLinks($tabellisting['actions'], $fields);

				$rows[$row]['td'][] = [
					'class' => 'text-end',
					'data' => [
						'macro' => 'actions',
						'data' => $actions
					]
				];
			}
		}

		return $rows;
	}

	private static function setLinks(array $actions, array $item): array
	{
		$linker = UI::getLinker();

		// Check each action for a href
		foreach ($actions as $key => $action) {
			// Call user function if visible is an array
			if (isset($action['visible']) && is_array($action['visible'])) {
				$actions[$key]['visible'] = call_user_func($action['visible'], ['fields' => $item]);
			}

			// Set link if href is an array
			if (isset($action['href']) && is_array($action['href'])) {
				// Search for "columns" in our href array
				foreach ($action['href'] as $href_key => $href_value) {
					$length = strlen(':');
					if (substr($href_value, 0, $length) === ':') {
						$column = ltrim($href_value, ':');
						$action['href'][$href_key] = $item[$column];
					}
				}

				// Set actual link from linker
				$actions[$key]['href'] = $linker->getLink($action['href']);
			}
		}

		return $actions;
	}

	public static function getVisibleColumnsForListing(string $listing, array $default_columns): array
	{
		// Here would come the logic that pulls this from the DB ...
		// alternatively, it takes the $default_columns if no entry is
		// defined in the DB

		return $default_columns;
	}

	public static function getMultiArrayFromString(array $arr, ?string $str)
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
