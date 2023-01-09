<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class Reprovacaomail extends Mailable
{
    use Queueable, SerializesModels;
    protected $atividade;
    protected $participantes_;
    protected $motivo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($atividade,$participantes_,$motivo)
    {
        $this->atividade = $atividade;
        $this->participantes_ = $participantes_;
        $this->motivo = $motivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email_reprovacao',['atividade' =>$this->atividade,'participantes_' => $this->participantes_, 'motivo' => $this->motivo ])
        ->subject('Reprovada Atividade de execução de serviços com periculosidade elétrica');
    }
}
