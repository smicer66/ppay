<?php

namespace App\Models;

class SaleItem extends MyModel
{

    function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }


}