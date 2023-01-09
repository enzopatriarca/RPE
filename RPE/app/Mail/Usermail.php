<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class Usermail extends Mailable
{
    use Queueable, SerializesModels;
    protected $atividade_;
    protected $user_participantes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($atividade_,$user_participantes)
    {
        $this->atividade_ = $atividade_;
        $this->user_participantes = $user_participantes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emailuser',['atividade_' =>$this->atividade_,'user_participantes' => $this->user_participantes ])
        ->subject('Aprovada Atividade de execução de serviços com periculosidade elétrica');
    }
}
