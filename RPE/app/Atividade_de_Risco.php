<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atividade_de_Risco extends Model{
    //

    protected $fillable = [
        'situacao','data_inicio','data_final','mes','ano','proprietario_id','data_situacao',
    ];

    public function A_atividade(){
        return $this->belongsTo(area__riscos::class); 
    }

    public function L_atividade(){
        return $this->belongsTo(locals::class); 
    }

    public function N_atividade(){
        return $this->belongsTo(natureza_atividades::class); 
    }

    public function H_atividade(){
        return $this->belongsTo(hashes::class); 
    }
}

