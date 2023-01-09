<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class mailprime extends Mailable 
{
    use Queueable, SerializesModels;
    protected $atividade;
    protected $hash_aprv;
    protected $hash_rprv;
    protected $user_participantes;
    protected $ip;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($atividade,$hash_aprv,$hash_rprv,$user_participantes,$ip)
    {
        $this->atividade = $atividade;
        $this->hash_aprv = $hash_aprv;
        $this->hash_rprv = $hash_rprv;
        $this->user_participantes = $user_participantes;
        $this->ip = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emailaprovacao',['atividade' =>$this->atividade, 'hash_aprv' =>  $this->hash_aprv, 'hash_rprv' => $this->hash_rprv,'user_participantes' => $this->user_participantes, 'ip' => $this->ip ])
        ->subject('Solicitar autorização para execução de serviços com periculosidade elétrica');
    }
}
