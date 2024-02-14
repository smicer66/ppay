<?php

namespace App\Models;

class   UserProfiles extends MyModel
{
    //

    function lga() {
        return $this->hasOne(Lga::class, 'id', 'lga_id');
    }

    function origin_lga() {
        return $this->hasOne(Lga::class, 'id', 'state_of_origin_lga_id');
    }
	
	function residentState() {
        return $this->hasOne(States::class, 'id', 'resident_state_id');
    }
}
