<?php

namespace App\Jobs;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Usermail;
use Mail;

class EnviarEmailUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $atividade_;
    protected $user_participantes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$atividade_,$user_participantes)
    {
        $this->details = $details;
        $this->atividade_ = $atividade_;
        $this->user_participantes = $user_participantes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Usermail($this->atividade_,$this->user_participantes);
        Mail::to($this->details)->send($email);
    }
}
