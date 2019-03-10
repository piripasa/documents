<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

define('PER_PAGE', env('PER_PAGE', 15));

class BaseModel extends Model {

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = PER_PAGE ;
    
    public function toArrayCamel()
    {
        $array = $this->toArray();

        foreach($array as $key => $value){
            $return[camel_case($key)] = $value;
        }

        return $return;
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }
}