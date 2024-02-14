<?php

namespace App\Models;

class PackageFeatures extends MyModel
{

    public function feature() {
        return $this->hasOne('App\Models\Features', 'id', 'feature_id');
    }
}
