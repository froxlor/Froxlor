<?php

namespace Froxlor\UI;

use Froxlor\Database\Database;
use Froxlor\UI\Panel\UI;
use InvalidArgumentException;
use Froxlor\CurrentUser;

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
		$collection_data = $collection->get();

		return [
			'title' => $tabellisting['title'],
			'description' => $tabellisting['description'] ?? null,
			'icon' => $tabellisting['icon'] ?? null,
			'table' => [
				'th' => self::generateTableHeadings($tabellisting),
				'tr' => self::generateTableRows($collection_data['data']['list'], $tabellisting),
			],
			'pagination' => $collection_data['pagination'],
			'empty_msg' => $tabellisting['empty_msg'] ?? null,
			'total_entries' => ($collection->getPagination() instanceof Pagination) ? $collection->getPagination()->getEntries() : 0,
			'is_search' => $collection->getPagination() instanceof Pagination && $collection->getPagination()->isSearchResult(),
			'self_overview' => $tabellisting['self_overview'] ?? [],
			'available_columns' => self::getAvailableColumnsForListing($tabellisting)
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
					throw new InvalidArgumentException('The visible column "' . $visible_column . '" has neither a "callback" nor a "field" set.');
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

			// modal trigger - always require a valid callback
			if (isset($action['modal']) && !empty($action['modal'])) {
				$actions[$key]['modal'] = call_user_func($action['modal'], ['fields' => $item]);
			}
		}

		return $actions;
	}

	private static function getAvailableColumnsForListing(array $tabellisting): array
	{
		$result = [];
		if (isset($tabellisting['columns'])) {
			foreach ($tabellisting['columns'] as $column => $coldata) {
				$result[$column] = $coldata['label'];
			}
		}
		return $result;
	}

	/**
	 * store column listing selection of user to database
	 * the selection array should look like this:
	 * [
	 *     'section_name' => [
	 *         'column_name',
	 *         'column_name',
	 *         'column_name'
	 *     ]
	 * ]
	 *
	 * @param array $tablelisting
	 *
	 * @return bool
	 */
	public static function storeColumnListingForUser(array $tabellisting): bool
	{
		$section = array_key_first($tabellisting);
		if (empty($section) || !is_array($tabellisting[$section]) || empty($tabellisting[$section])) {
			throw new InvalidArgumentException("Invalid selection array for " . __METHOD__);
		}
		$userid = 'customerid';
		if (CurrentUser::isAdmin()) {
			$userid = 'adminid';
		}
		// delete possible existing entry
		$del_stmt = Database::prepare("
			DELETE FROM `" . TABLE_PANEL_USERCOLUMNS . "` WHERE `" . $userid . "` = :uid AND `section` = :section
		");
		Database::pexecute($del_stmt, ['uid' => CurrentUser::getField($userid), 'section' => $section]);
		// add new entry
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_USERCOLUMNS . "` SET
			`" . $userid . "` = :uid,
			`section` = :section,
			`columns` = :cols
		");
		Database::pexecute($ins_stmt, [
			'uid' => CurrentUser::getField($userid),
			'section' => $section,
			'cols' => json_encode($tabellisting[$section])
		]);
		return true;
	}

	public static function getVisibleColumnsForListing(string $listing, array $default_columns): array
	{
		$userid = 'customerid';
		if (CurrentUser::isAdmin()) {
			$userid = 'adminid';
		}
		$sel_stmt = Database::prepare("
			SELECT `columns` FROM `" . TABLE_PANEL_USERCOLUMNS . "` WHERE `" . $userid . "` = :uid AND `section` = :section
		");
		$columns_json = Database::pexecute_first($sel_stmt, ['uid' => CurrentUser::getField($userid), 'section' => $listing]);
		if ($columns_json && isset($columns_json['columns'])) {
			return json_decode($columns_json['columns'], true);
		}
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
