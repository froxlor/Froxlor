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
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Collection
 *
 */
class Collection
{
    private array $items;
    private array $userInfo;
    private array $params;
    private string $class;

    public function __construct($class, $userInfo, $params = [])
    {
        $this->class = $class;
        $this->params = $params;
        $this->userInfo = $userInfo;

        $this->items = $this->getListing($this->class, $this->params);
    }

    private function getListing($class, $params)
    {
        return json_decode($class::getLocal($this->userInfo, $params)->listing(), true);
    }

    public function count()
    {
        return json_decode($this->class::getLocal($this->userInfo, $this->params)->listingCount(), true);
    }

    public function get()
    {
        return $this->items;
    }

    public function getData()
    {
        return $this->get()['data'];
    }

    public function getJson()
    {
        return json_encode($this->get());
    }

    public function has($column, $class, $parentKey = 'id', $childKey = 'id', $params = [])
    {
        $attributes = $this->getListing($class, $params);

        foreach ($this->items['data']['list'] as $key => $item) {
            foreach ($attributes['data']['list'] as $list) {
                if ($item[$parentKey] == $list[$childKey]) {
                    $this->items['data']['list'][$key][$column] = $list;
                }
            }
        }
    }
}