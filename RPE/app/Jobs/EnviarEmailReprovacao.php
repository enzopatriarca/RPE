<?php

namespace App\Jobs;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Reprovacaomail;
use Mail;

class EnviarEmailReprovacao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $atividade;
    protected $participantes_;
    protected $motivo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$atividade,$participantes_,$motivo)
    {
        $this->details = $details;
        $this->atividade = $atividade;
        $this->participantes_ = $participantes_;
        $this->motivo = $motivo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Reprovacaomail($this->atividade,$this->participantes_,$this->motivo);
        Mail::to($this->details)->send($email);
    }
}
