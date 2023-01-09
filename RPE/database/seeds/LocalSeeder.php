<?php

use Illuminate\Database\Seeder;
use App\Local;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Local::create([
            'nome_local' => 'E02 - Lab. Concreto',
        ]);

        Local::create([
            'nome_local' => 'E03 - Coordenação',
        ]);

        Local::create([
            'nome_local' => 'E04 - Sup. Informática',
        ]);

        Local::create([
            'nome_local' => 'E05 - Central Telefônica',
        ]);

        Local::create([
            'nome_local' => 'E06 - Planej. Empresarial',
        ]);

        Local::create([
            'nome_local' => 'E07 - Escritório Central',
        ]);

        Local::create([
            'nome_local' => 'E08 - Shumodromo',
        ]);

        Local::create([
            'nome_local' => 'E09 - Seg. Empresarial',
        ]);

        Local::create([
            'nome_local' => 'E10 - Treinamento',
        ]);

        Local::create([
            'nome_local' => 'E10 - Treinamento',
        ]);
        Local::create([
            'nome_local' => 'E11 - Almoxarifado',
        ]);
        Local::create([
            'nome_local' => 'E12 - Transporte',
        ]);
        Local::create([
            'nome_local' => 'E13 - CRV',
        ]);
        Local::create([
            'nome_local' => 'E14 - Ecomuseu',
        ]);
        Local::create([
            'nome_local' => 'E15 - CEX',
        ]);
        Local::create([
            'nome_local' => 'E17 - Refúgio Biológico',
        ]);
        Local::create([
            'nome_local' => 'Usina -  Edifício de Produção',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 98',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 108',
        ]);

        Local::create([
            'nome_local' => 'Usina - Cota 115',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 127',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 128',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 133',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 144',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 214',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 225',
        ]);
        Local::create([
            'nome_local' => 'Usina - Cota 171',
        ]);
        Local::create([
            'nome_local' => 'Usina - Vertedouro',
        ]);
        

    }
}
