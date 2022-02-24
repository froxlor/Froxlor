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
    private string $class;
    private array $has = [];
    private array $params;
    private array $userinfo;

    public function __construct(string $class, array $userInfo, array $params = [])
    {
        $this->class = $class;
        $this->params = $params;
        $this->userinfo = $userInfo;
    }

    private function getListing($class, $params): array
    {
        return json_decode($class::getLocal($this->userinfo, $params)->listing(), true);
    }

    public function count(): int
    {
        return json_decode($this->class::getLocal($this->userinfo, $this->params)->listingCount(), true)['data'];
    }

    public function get(): array
    {
        $result = $this->getListing($this->class, $this->params);

        // check if the api result contains any items (not the overall listingCount as we might be in a search-resultset)
        if (count($result)) {
            foreach ($this->has as $has) {
                $attributes = $this->getListing($has['class'], $has['params']);

                foreach ($result['data']['list'] as $key => $item) {
                    foreach ($attributes['data']['list'] as $list) {
                        if ($item[$has['parentKey']] == $list[$has['childKey']]) {
                            $result['data']['list'][$key][$has['column']] = $list;
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function getData(): array
    {
        return $this->get()['data'];
    }

    public function getList(): array
    {
        return $this->getData()['list'];
    }

    public function getJson(): string
    {
        return json_encode($this->get());
    }

    public function has(string $column, string $class, string $parentKey = 'id', string $childKey = 'id', array $params = []): Collection
    {
        $this->has[] = [
           'column' => $column,
           'class' => $class,
           'parentKey' => $parentKey,
           'childKey' => $childKey,
           'params' => $params
        ];

        return $this;
    }

    public function withPagination(array $columns): Collection
    {
        // TODO: handle 'sortable' => true in $columns

        $pagination = new Pagination($this->userinfo, $columns, $this->count());
        $this->params = array_merge($this->params, $pagination->getApiCommandParams());

        return $this;
    }
}
