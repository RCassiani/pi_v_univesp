<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            ['name' => 'role-list', 'display_name' => 'Permissões - Consultar', 'guard_name' => 'web'],
            ['name' => 'role-create', 'display_name' => 'Permissões - Cadastrar', 'guard_name' => 'web'],
            ['name' => 'role-edit', 'display_name' => 'Permissões - Editar', 'guard_name' => 'web'],
            ['name' => 'role-delete', 'display_name' => 'Permissões - Excluir', 'guard_name' => 'web'],

            ['name' => 'user-list', 'display_name' => 'Usuários - Consultar', 'guard_name' => 'web'],
            ['name' => 'user-create', 'display_name' => 'Usuários - Cadastrar', 'guard_name' => 'web'],
            ['name' => 'user-edit', 'display_name' => 'Usuários - Editar', 'guard_name' => 'web'],
            ['name' => 'user-delete', 'display_name' => 'Usuários - Excluir', 'guard_name' => 'web']

        ]);

        DB::table('roles')->insert([
            ['name' => 'Professor', 'guard_name' => 'web'],
            ['name' => 'Aluno', 'guard_name' => 'web']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
