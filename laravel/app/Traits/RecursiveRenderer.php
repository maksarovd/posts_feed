<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;


trait RecursiveRenderer
{

    private $nested = [];

    private $models = [];


    /**
     * Simplify Nesting
     *
     *
     * @param Collection $collection
     * @access public
     * @return array
     */
    public function simplifyNesting(Collection $collection)
    {
        foreach($collection->getIterator() as $iteration => $model){

            if(empty($this->nested[$model->parent_id])){
                $this->nested[$model->id] = 1;
            }else{
                $this->nested[$model->id] = $this->nested[$model->parent_id]++;
            }
            $model->nested = $this->nested[$model->id];



            $this->models[] = $model;

            $collection = $this->childrenComments($model->id);

            if(count($collection)){
                $this->simplifyNesting($collection);
            }
        }


        return $this->models;
    }
}
