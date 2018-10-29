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
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *
 */
class Traffic extends ApiCommand implements ResourceEntity
{

	/**
	 * You cannot add traffic data
	 */
	public function add()
	{
		throw new Exception('You cannot add traffic data', 303);
	}

	public function get()
	{
		
	}

	/**
	 * You cannot update traffic data
	 */
	public function update()
	{
		throw new Exception('You cannot update traffic data', 303);
	}

	public function listing()
	{
		
	}

	/**
	 * You cannot delete traffic data
	 */
	public function delete()
	{
		throw new Exception('You cannot delete traffic data', 303);
	}
}
