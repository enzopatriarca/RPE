<?php

use Illuminate\Database\Seeder;
use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;

class UserSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nome' => 'Alexandre Torchelsen Feldens',
            'name' => 'afeldens',
            'password' => bcrypt('afeldens'),
            'cargo' => 'Técnico Manutenção Eletrônica III',
            'matricula' => '003894-2',
            'email' =>'afeldens@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '426',
        ])->assignRole('User');

        User::create([
            'nome' => 'Aluizio Henrique Bezagio',
            'name' => 'aluizio',
            'password' => bcrypt('aluizio'),
            'cargo' => 'Técnico de Manutenção Eletrônica IV',
            'matricula' => '003879-4',
            'email' =>'aluizio@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '581',
        ])->assignRole('User');

        User::create([
            'nome' => 'Diego Franco Martins',
            'name' => 'diegofm',
            'password' => bcrypt('diegofm'),
            'cargo' => 'Engenheiro de Telecomunicações Junior',
            'matricula' => '004618-0',
            'email' =>'diegofm@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => ' 999',
        ])->assignRole('User');

        User::create([
            'nome' => 'Ediney Jose Goncalves De Oliveira',
            'name' => 'ediney',
            'password' => bcrypt('ediney'),
            'cargo' => ' Eletrônico III',
            'matricula' => '003181-2',
            'email' =>'ediney@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => ' 506',
        ])->assignRole('User');
        
        User::create([
            'nome' => 'Felipe Diego Morais Goldoni',
            'name' => 'fgoldoni',
            'password' => bcrypt('fgoldoni'),
            'cargo' => 'PNF III',
            'matricula' => '004054-4',
            'email' =>'fgoldoni@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '575',
        ])->assignRole('User');

        User::create([
            'nome' => 'Gustavo Quenehen Dos Santos',
            'name' => 'gustavoq',
            'password' => bcrypt('gustavoq'),
            'cargo' => 'PNF IV',
            'matricula' => '003873-3',
            'email' =>'gustavoq@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '430',
        ])->assignRole('User');
        
        User::create([
            'nome' => 'Lucas Soares Do Nascimento',
            'name' => 'lsoares',
            'password' => bcrypt('lsoares'),
            'cargo' => 'Analista de Suporte Pleno II',
            'matricula' => ' 004229-7',
            'email' =>'lsoares@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '477' ,
        ])->assignRole('Admin');

        User::create([
            'nome' => 'Marcelo Lago',
            'name' => 'marlago',
            'password' => bcrypt('marlago'),
            'cargo' => 'Técnico Manutenção Eletrônica  V',
            'matricula' => '003288-2',
            'email' =>'marlago@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '427' ,
        ])->assignRole('User');

        User::create([
            'nome' => 'Otavio Colaco',
            'name' => 'ocolaco',
            'password' => bcrypt('ocolaco'),
            'cargo' => 'Analista de Suporte Pleno I',
            'matricula' => '004284-0',
            'email' =>'ocolaco@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => ' 507' ,
        ])->assignRole('User');

        User::create([
            'nome' => 'Pedro Toshio Yaegashi ',
            'name' => 'pedroty',
            'password' => bcrypt('pedroty'),
            'cargo' => 'Engenheiro de Telecomunicações Pleno III',
            'matricula' => '003875-7',
            'email' =>'pedroty@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '424' ,
        ])->assignRole('Supervisor');
        
        User::create([
            'nome' => 'Silvio Jose Silvestre',
            'name' => 'silvio',
            'password' => bcrypt('silvio'),
            'cargo' => 'PNU SR II',
            'matricula' => '002282-7',
            'email' =>'silvio@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => ' 538' ,
        ])->assignRole('User');

        User::create([
            'nome' => 'Eduardo Cesar Fernandes',
            'name' => 'eduardoc',
            'password' => bcrypt('eduardoc'),
            'cargo' => 'Gerente',
            'matricula' => ' 003454-9',
            'email' =>'eduardoc@itaipu.gov.br',
            'Lotacao' => 'SITT.AA',
            'autorizacao' => '888' ,
            'Aprovador' =>'1'
        ])->assignRole('Admin');
        

    }
}
