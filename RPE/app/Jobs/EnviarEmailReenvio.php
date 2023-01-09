<?php

namespace App\Jobs;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Reenviomail;
use Mail;

class EnviarEmailReenvio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $atividade;
    protected $hash_aprv;
    protected $hash_rprv;
    protected $participantes_;
    protected $ip;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$atividade,$hash_aprv, $hash_rprv,$participantes_,$ip)
    {
        $this->details = $details;
        $this->atividade = $atividade;
        $this->hash_aprv = $hash_aprv;
        $this->hash_rprv = $hash_rprv;
        $this->participantes_ = $participantes_;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Reenviomail($this->atividade, $this->hash_aprv,$this->hash_rprv, $this->participantes_,$this->ip);
        Mail::to($this->details['email'])->send($email);
    }
}
