<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area_atividade extends Model
{
    //

    public function area(){
       return $this->belongsTo(area__riscos::class); 
    }
}
