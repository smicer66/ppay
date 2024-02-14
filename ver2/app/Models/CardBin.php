<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardBin extends MyModel
{

    use SoftDeletes;

    protected $table = 'card_bins';


}