<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario_atividade extends Model
{
    //

    public function usuario(){
        return $this->belongsTo(users::class); 
     }
}
