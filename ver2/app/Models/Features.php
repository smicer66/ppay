<?php

namespace App\Models;

class Features extends MyModel
{

    public function features(){
        return $this->belongsTo('App\Models\PackageFeatures');
    }
}
