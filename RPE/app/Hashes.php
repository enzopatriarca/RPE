<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hashes extends Model
{
    //
    public function hashes_atividade(){
        return $this->hasMany(atividade_de__riscos::class);
    }
}
