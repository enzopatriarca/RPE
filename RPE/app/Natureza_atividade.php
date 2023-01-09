<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Natureza_atividade extends Model
{
    //

    protected $fillable = [
        'nome_natureza',
    ];

    public function natureza_atividade(){
        return $this->hasMany(natureza_de_atividades::class);
    }

    public function atividade_de_risco_N(){
        return $this->hasMany(atividade_de__riscos::class);
    }
}
