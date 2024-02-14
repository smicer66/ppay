<?php

namespace App\Models;

class Packages extends MyModel
{

    public function packageFeatures(){
        return $this->hasMany('App\Models\PackageFeatures', 'package_id', 'id');
    }
}
