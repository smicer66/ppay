<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Eloquence\Database\Traits\CamelCaseModel;

class MyModel extends Model
{
    //use CamelCaseModel;
    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(\Str::snake($key));
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(\Str::snake($key), $value);
    }

}
