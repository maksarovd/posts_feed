<?php

namespace App\Services;

use Illuminate\Http\Request;


class SortService
{

    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * Is Selected
     *
     *
     * @param $sortBy
     * @param $orderBy
     * @access public
     * @return string
     */
    public function isSelected($sortBy, $orderBy)
    {
        return (
            ($this->request->get('sortBy') === $sortBy) &&
            ($this->request->get('orderBy') === $orderBy)) ? 'selected' : '';
    }

}
