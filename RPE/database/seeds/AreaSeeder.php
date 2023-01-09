<?php

use Illuminate\Database\Seeder;
use App\Area_Risco;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Area_Risco::create([
            'nome_area' => 'Estruturas, condutores e equipamentos de transmissão e distribuição.',
        ]);
        
        Area_Risco::create([
            'nome_area' => 'Valas, canaletas, poços de inspeção e galerias de redes de alta e baixa tensão integrantes do SEP',
        ]); 

        Area_Risco::create([
            'nome_area' => 'Pontos de medição e cabinas de distribuição.',
        ]);
        
        Area_Risco::create([
            'nome_area' => 'Unidades geradoras, salas de controle, casa de máquinas, barragem e vertedouro.',
        ]);
        
        Area_Risco::create([
            'nome_area' => 'Pátios e salas de operações de subestações.',
        ]);
        
        Area_Risco::create([
            'nome_area' => 'Oficinas e laboratórios de testes e manutenção elétrica, eletronica e eletromecanica.',
        ]); 
        
    }
}
