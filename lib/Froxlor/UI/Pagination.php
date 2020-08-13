<?php
namespace Froxlor\UI;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package API
 * @since 0.10.0
 *       
 */

/**
 * Class to manage pagination, limiting and ordering
 */
class Pagination
{

	private $data = array();

	private $fields = null;

	public $sortorder = 'ASC';

	public $sortfield = null;

	private $searchtext = null;

	private $searchfield = null;

	private $is_search = false;

	private $pageno = 0;

	private $entries = 0;

	/**
	 * Create new pagination object to search/filter, limit and sort Api-listing() calls
	 *
	 * @param array $userinfo
	 * @param array $fields
	 * @param number $total_entries
	 */
	public function __construct($userinfo, $fields = array(), $total_entries = 0)
	{
		$this->fields = $fields;
		$this->entries = $total_entries;
		$this->pageno = 1;
		// add default limitation by settings
		$this->addLimit(\Froxlor\Settings::Get('panel.paging'));
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
		if (! empty($this->searchtext) && ! empty($this->searchfield)) {
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
		if (($this->pageno - 1) * \Froxlor\Settings::Get('panel.paging') > $this->entries) {
			$this->pageno = 1;
		}
		$this->addOffset(($this->pageno - 1) * \Froxlor\Settings::Get('panel.paging'));
	}

	/**
	 * add a field for ordering
	 *
	 * @param string $field
	 * @param string $order
	 *        	optional, default 'ASC'
	 *        	
	 * @return \Froxlor\UI\Pagination
	 */
	public function addOrderBy($field = null, $order = 'ASC')
	{
		if (! isset($this->data['sql_orderby'])) {
			$this->data['sql_orderby'] = array();
		}
		$this->data['sql_orderby'][$field] = $order;
		return $this;
	}

	/**
	 * add a limit
	 *
	 * @param number $limit
	 *        	optional, default 0
	 *        	
	 * @return \Froxlor\UI\Pagination
	 */
	public function addLimit($limit = 0)
	{
		$this->data['sql_limit'] = (int) $limit;
		return $this;
	}

	/**
	 * add an offset
	 *
	 * @param number $offset
	 *        	optional, default 0
	 *        	
	 * @return \Froxlor\UI\Pagination
	 */
	public function addOffset($offset = 0)
	{
		$this->data['sql_offset'] = (int) $offset;
		return $this;
	}

	/**
	 * add a search operation
	 *
	 * @param string $searchtext
	 * @param string $field
	 * @param string $operator
	 *
	 * @return \Froxlor\UI\Pagination
	 */
	public function addSearch($searchtext = null, $field = null, $operator = null)
	{
		if (! isset($this->data['sql_search'])) {
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
	public function getEntries()
	{
		return $this->entries;
	}

	/**
	 * Returns html code for sorting field
	 *
	 * @param array $lng
	 *        	Language array
	 * @return string the html sortcode
	 */
	public function getHtmlSortCode($lng, $break = false)
	{
		$sortcode = '';
		$fieldoptions = '';
		$orderoptions = '';

		foreach ($this->fields as $fieldname => $fieldcaption) {
			$fieldoptions .= HTML::makeoption($fieldcaption, $fieldname, $this->sortfield, true, true);
		}

		$breakorws = ($break ? '<br />' : '&nbsp;');
		foreach (array(
			'asc' => $lng['panel']['ascending'],
			'desc' => $lng['panel']['descending']
		) as $sortordertype => $sortorderdescription) {
			$orderoptions .= HTML::makeoption($sortorderdescription, $sortordertype, $this->sortorder, true, true);
		}

		eval("\$sortcode =\"" . Template::getTemplate("misc/htmlsortcode", '1') . "\";");
		return $sortcode;
	}

	/**
	 * Returns html code for sorting arrows
	 *
	 * @param string $baseurl
	 *        	URL to use as base for links
	 * @param string $field
	 *        	If set, only this field will be returned
	 *        	
	 * @return mixed An array or a string (if field is set) of html code of arrows
	 */
	public function getHtmlArrowCode($baseurl, $field = '')
	{
		global $theme;
		if ($field != '' && isset($this->fields[$field])) {
			$baseurl = htmlspecialchars($baseurl);
			$fieldname = htmlspecialchars($field);
			eval("\$arrowcode =\"" . Template::getTemplate("misc/htmlarrowcode", '1') . "\";");
		} else {
			$baseurl = htmlspecialchars($baseurl);
			$arrowcode = array();
			foreach ($this->fields as $fieldname => $fieldcaption) {
				$fieldname = htmlspecialchars($fieldname);
				eval("\$arrowcode[\$fieldname] =\"" . Template::getTemplate("misc/htmlarrowcode", '1') . "\";");
			}
		}
		return $arrowcode;
	}

	/**
	 * Returns html code for searching field
	 *
	 * @param array $lng
	 *        	Language array
	 *        	
	 * @return string the html searchcode
	 */
	public function getHtmlSearchCode($lng)
	{
		$searchcode = '';
		$fieldoptions = '';
		$searchtext = htmlspecialchars($this->searchtext);
		foreach ($this->fields as $fieldname => $fieldcaption) {
			$fieldoptions .= HTML::makeoption($fieldcaption, $fieldname, $this->searchfield, true, true);
		}
		eval("\$searchcode =\"" . Template::getTemplate("misc/htmlsearchcode", '1') . "\";");
		return $searchcode;
	}

	/**
	 * Returns html code for paging
	 *
	 * @param string $baseurl
	 *        	URL to use as base for links
	 *        	
	 * @return string the html pagingcode
	 */
	public function getHtmlPagingCode($baseurl)
	{
		if (\Froxlor\Settings::Get('panel.paging') == 0 || $this->is_search) {
			return '';
		} else {
			$pages = intval($this->getEntries() / \Froxlor\Settings::Get('panel.paging'));
		}

		if ($this->getEntries() % \Froxlor\Settings::Get('panel.paging') != 0) {
			$pages ++;
		}

		if ($pages > 1) {

			$start = $this->pageno - 4;
			if ($start < 1) {
				$start = 1;
			}

			$stop = $this->pageno + 4;
			if ($stop > $pages) {
				$stop = $pages;
			}

			// check for possible sorting values and keep it
			$orderstr = '';
			if (!empty($this->sortfield)) {
				$fieldname = htmlspecialchars($this->sortfield);
				$orderstr .= '&amp;sortfield=' . $fieldname . '&amp;sortorder=' . $this->sortorder;
			}

			$pagingcode = '<a href="' . htmlspecialchars($baseurl) . '&amp;pageno=1' . $orderstr . '">&laquo;</a> <a href="' . htmlspecialchars($baseurl) . '&amp;pageno=' . ((intval($this->pageno) - 1) == 0 ? '1' : intval($this->pageno) - 1) . $orderstr . '">&lt;</a>&nbsp;';
			for ($i = $start; $i <= $stop; $i ++) {
				if ($i != $this->pageno) {
					$pagingcode .= ' <a href="' . htmlspecialchars($baseurl) . '&amp;pageno=' . $i . $orderstr . '">' . $i . '</a>&nbsp;';
				} else {
					$pagingcode .= ' <strong>' . $i . '</strong>&nbsp;';
				}
			}
			$pagingcode .= ' <a href="' . htmlspecialchars($baseurl) . '&amp;pageno=' . ((intval($this->pageno) + 1) > $pages ? $pages : intval($this->pageno) + 1) . $orderstr . '">&gt;</a> <a href="' . $baseurl . '&amp;pageno=' . $pages . $orderstr . '">&raquo;</a>';
		} else {
			$pagingcode = '';
		}

		return $pagingcode;
	}

	/**
	 * return parameter array for API command parameters $sql_search, $sql_limit, $sql_offset and $sql_orderby
	 *
	 * @return array
	 */
	public function getApiCommandParams()
	{
		return $this->data;
	}
}
