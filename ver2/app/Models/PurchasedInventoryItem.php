<?php

namespace App\Models;

class PurchasedInventoryItem extends MyModel
{

    function inventoryItem()
    {
        return $this->hasOne(InventoryItem::class, 'id', 'inventory_item_id');
    }


    function purchasedBy()
    {
        return $this->hasOne(User::class, 'id', 'purchased_by_user_id');
    }


}