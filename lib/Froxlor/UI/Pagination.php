<?php

namespace Froxlor\UI;

use Froxlor\Settings;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *       
 */

/**
 * Class to manage pagination, limiting and ordering
 */
class Pagination
{
	private array $data = array();

	private ?array $fields = null;

	public string $sortorder = 'ASC';

	public $sortfield = null;

	private ?string $searchtext = null;

	private $searchfield = null;

	private bool $is_search = false;

	private int $pageno = 0;

	private int $entries = 0;

	private int $perPage;

	/**
	 * Create new pagination object to search/filter, limit and sort Api-listing() calls
	 *
	 * @param array $fields
	 * @param int $total_entries
	 * @param int $perPage
	 */
	public function __construct(array $fields = array(), int $total_entries = 0, int $perPage = 20)
	{
		$this->fields = $fields;
		$this->entries = $total_entries;
		$this->perPage = $perPage;
		$this->pageno = 1;
		// add default limitation by settings
		$this->addLimit(Settings::Get('panel.paging'));
		// check search request
		$this->searchtext = '';
		if (count($fields) > 0) {
			$orderfields = array_keys($fields);
			$this->searchfield = $orderfields[0];
		}
		if (isset($_REQUEST['searchtext']) && (preg_match('/[-_@\p{L}\p{N}*.]+$/u', $_REQUEST['searchtext']) || $_REQUEST['searchtext'] === '')) {
			$this->searchtext = trim($_REQUEST['searchtext']);
		}
		if (isset($_REQUEST['searchfield']) && isset($fields[$_REQUEST['searchfield']])) {
			$this->searchfield = $_REQUEST['searchfield'];
		}
		if (!empty($this->searchtext) && !empty($this->searchfield)) {
			$this->addSearch($this->searchtext, $this->searchfield);
		}

		// check other ordering requests
		if (isset($_REQUEST['sortorder']) && (strtolower($_REQUEST['sortorder']) == 'desc' || strtolower($_REQUEST['sortorder']) == 'asc')) {
			$this->sortorder = strtoupper($_REQUEST['sortorder']);
		}
		if (isset($_REQUEST['sortfield']) && isset($fields[$_REQUEST['sortfield']])) {
			$this->sortfield = $_REQUEST['sortfield'];
			$this->addOrderBy($this->sortfield, $this->sortorder);
		} else {
			// add default ordering by given fields
			if (count($fields) > 0) {
				$orderfields = array_keys($fields);
				$this->sortfield = $orderfields[0];
				$this->addOrderBy($orderfields[0], $this->sortorder);
			}
		}

		// check current page / pages
		if (isset($_REQUEST['pageno']) && intval($_REQUEST['pageno']) != 0) {
			$this->pageno = intval($_REQUEST['pageno']);
		}
		if (($this->pageno - 1) * Settings::Get('panel.paging') > $this->entries) {
			$this->pageno = 1;
		}
		$this->addOffset(($this->pageno - 1) * Settings::Get('panel.paging'));
	}

	/**
	 * add a field for ordering
	 *
	 * @param string $field
	 * @param string $order optional, default 'ASC'
	 * @return Pagination
	 */
	public function addOrderBy($field = null, $order = 'ASC'): Pagination
	{
		if (!isset($this->data['sql_orderby'])) {
			$this->data['sql_orderby'] = array();
		}
		$this->data['sql_orderby'][$field] = $order;
		return $this;
	}

	/**
	 * add a limit
	 *
	 * @param int $limit
	 *        	optional, default 0
	 *        	
	 * @return Pagination
	 */
	public function addLimit(int $limit = 0): Pagination
	{
		$this->data['sql_limit'] = $limit;
		return $this;
	}

	/**
	 * add an offset
	 *
	 * @param int $offset optional, default 0
	 * @return Pagination
	 */
	public function addOffset(int $offset = 0): Pagination
	{
		$this->data['sql_offset'] = $offset;
		return $this;
	}

	/**
	 * add a search operation
	 *
	 * @param string|null $searchtext
	 * @param string|null $field
	 * @param string|null $operator
	 *
	 * @return Pagination
	 */
	public function addSearch(string $searchtext = null, string $field = null, string $operator = null): Pagination
	{
		if (!isset($this->data['sql_search'])) {
			$this->data['sql_search'] = array();
		}
		$this->data['sql_search'][$field] = [
			'value' => $searchtext,
			'op' => $operator
		];
		// if a search is performed, the result-entries-count is irrelevant
		// we do not want pagination
		$this->is_search = true;
		// unset any limit as we do not have pagination when showing search-results
		unset($this->data['sql_limit']);
		unset($this->data['sql_offset']);
		return $this;
	}

	/**
	 * return number of total entries the user can access from the current resource
	 *
	 * @return number
	 */
	public function getEntries(): int
	{
		return $this->entries;
	}

	public function getApiCommandParams(): array
	{
		return $this->data;
	}

	public function getApiResponseParams(): array
	{
		return [
			'pagination' => [
				"total" => $this->entries,
				"per_page" => $this->perPage,
				"current_page" => $this->pageno,
				"last_page" => ceil($this->entries / $this->perPage),
				"from" => $this->data['sql_offset'] ?? null,
				"to" => min($this->data['sql_offset'] + $this->perPage, $this->entries),
				'sortfields' => array_keys($this->fields),
			]
		];
	}

	public function isSearchResult(): bool
	{
		return $this->is_search;
	}
}
