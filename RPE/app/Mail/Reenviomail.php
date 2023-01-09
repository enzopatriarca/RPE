<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reenviomail extends Mailable
{
    use Queueable, SerializesModels;
    protected $atividade;
    protected $hash_aprv;
    protected $hash_rprv;
    protected $participantes_;
    protected $ip;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($atividade,$hash_aprv, $hash_rprv,$participantes_,$ip)
    {
        $this->atividade = $atividade;
        $this->hash_aprv = $hash_aprv;
        $this->hash_rprv = $hash_rprv;
        $this->participantes_ = $participantes_;
        $this->ip = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email_reenvio',['atividade' =>$this->atividade,'participantes_' => $this->participantes_, 'hash_aprv' => $this->hash_aprv, 'hash_rprv' => $this->hash_rprv, 'ip' => $this->ip ])
        ->subject('Solicitar autorização para execução de serviços com periculosidade elétrica');
    }
}
