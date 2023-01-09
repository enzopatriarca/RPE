<?php

use Illuminate\Database\Seeder;
use App\Natureza_atividade;

class NaturezaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Natureza_atividade::create([
            'nome_natureza' => 'Construção ou ampliação',
        ]);

        Natureza_atividade::create([
            'nome_natureza' => 'Operação',
        ]);

        Natureza_atividade::create([
            'nome_natureza' => 'Manutenção e reparos',
        ]);

        Natureza_atividade::create([
            'nome_natureza' => 'Teste, ensaios, medição, calibração ou levantamento',
        ]);

        Natureza_atividade::create([
            'nome_natureza' => 'Inspeção, fiscalização ou supervisão',
        ]);

        Natureza_atividade::create([
            'nome_natureza' => 'Treinamento em equipamentos ou instalações integrantes do SEP',
        ]);
    }
}
