<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model{
    //

    protected $fillable = [
        'nome_local',
    ];

    public function Local_atividade(){
        return $this->hasMany(local_atividades::class);
    }

    public function atividade_de_risco_L(){
        return $this->hasMany(atividade_de__riscos::class);
    }
}
