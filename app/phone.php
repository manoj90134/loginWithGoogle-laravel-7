<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phone extends Model
{
    //


public function user(){
    return $this->belongsTo(user::class);
}

}
