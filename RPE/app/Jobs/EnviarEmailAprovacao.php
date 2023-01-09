<?php

namespace App\Jobs;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\mailprime;
use Mail;

class EnviarEmailAprovacao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $atividade;
    protected $hash_aprv;
    protected $hash_rprv;
    protected $user_participantes;
    protected $ip;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$atividade, $hash_aprv,$hash_rprv,$user_participantes,$ip)
    {
        $this->details = $details;
        $this->atividade = $atividade;
        $this->hash_aprv = $hash_aprv;
        $this->hash_rprv = $hash_rprv;
        $this->user_participantes = $user_participantes;
        $this->ip = $ip;

    }
  
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new mailprime($this->atividade,$this->hash_aprv,$this->hash_rprv,$this->user_participantes,$this->ip);
        Mail::to($this->details['email'])->send($email);

        /*if (Mail::failures($email)) {
            return redirect('/dashboard')->with('msg','Erro no envio do email!');
        }*/
    }
}
