<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area_Risco extends Model
{
    //

    protected $fillable = [
        'nome_area',
    ];

    public function area_atividade(){
        return $this->hasMany(area_atividades::class);
    }

    public function atividade_de_risco(){
        return $this->hasMany(atividade_de__riscos::class);
    }
}
