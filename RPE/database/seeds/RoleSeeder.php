<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'User']);
        $role3 = Role::create(['name' => 'Supervisor']);


        //all user
        Permission::create(['name' => 'dashboard'])->syncroles([$role1,$role2,$role3]);
        Permission::create(['name' => 'dashboard.Listar'])->syncroles([$role1,$role2,$role3]);
        //Permission::create(['name' => 'dashboard.eliminar'])->syncroles([$role1,$role2]);
        Permission::create(['name' => 'dashboard.registrar_atvidade'])->syncroles([$role1,$role2]);
        Permission::create(['name' => 'dashboard.pdf'])->syncroles([$role1,$role2]);


        //user
        //(->assignRole($role1);)
        Permission::create(['name' => 'dashboard.Listar_locais'])->syncroles([$role1,$role2,$role3]);
        Permission::create(['name' => 'dashboard.Listar_Natureza'])->syncroles([$role1,$role2,$role3]);

        


        //Admin
        Permission::create(['name' => 'dashboard.editar'])->syncroles([$role1,$role3]);
        Permission::create(['name' => 'dashboard.registrar_user'])->syncroles([$role1]);
        Permission::create(['name' => 'dashboard.registrar_local'])->syncroles([$role1]);
        Permission::create(['name' => 'dashboard.registrar_natureza'])->syncroles([$role1]);

        //Supervisor
        Permission::create(['name' => 'dashboard.editar_registro_usuario'])->syncroles([$role1,$role3]);
        Permission::create(['name' => 'dashboard.validar_atividade'])->syncroles([$role3]);


        //unico
        Permission::create(['name' => 'permissao_de_pagina_adm'])->syncroles([$role1]);
        Permission::create(['name' => 'permissao_de_pagina_user'])->syncroles([$role2]);
        Permission::create(['name' => 'permissao_de_pagina_supervisor'])->syncroles([$role3]);
        Permission::create(['name' => 'permissao_de_pagina_adm_super'])->syncroles([$role1,$role3]);

    }
}
