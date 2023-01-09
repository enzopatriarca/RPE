<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local_atividade extends Model
{
    //

    public function Local(){
        return $this->belongsTo(locals::class); 
     }
}
