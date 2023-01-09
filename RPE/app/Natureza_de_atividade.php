<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Natureza_de_atividade extends Model
{
    //

    public function natureza(){
        return $this->belongsTo(natureza_atividades::class); 
     }
}
