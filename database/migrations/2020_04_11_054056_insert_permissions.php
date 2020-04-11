<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            ['name' => 'class-list', 'display_name' => 'Matérias - Consultar', 'guard_name' => 'web'],
            ['name' => 'class-create', 'display_name' => 'Matérias - Cadastrar', 'guard_name' => 'web'],
            ['name' => 'class-edit', 'display_name' => 'Matérias - Editar', 'guard_name' => 'web'],
            ['name' => 'class-delete', 'display_name' => 'Matérias - Excluir', 'guard_name' => 'web'],

            ['name' => 'subject-list', 'display_name' => 'Assuntos - Consultar', 'guard_name' => 'web'],
            ['name' => 'subject-create', 'display_name' => 'Assuntos - Cadastrar', 'guard_name' => 'web'],
            ['name' => 'subject-edit', 'display_name' => 'Assuntos - Editar', 'guard_name' => 'web'],
            ['name' => 'subject-delete', 'display_name' => 'Assuntos - Excluir', 'guard_name' => 'web'],

            ['name' => 'post-list', 'display_name' => 'Publicações - Consultar', 'guard_name' => 'web'],
            ['name' => 'post-create', 'display_name' => 'Publicações - Cadastrar', 'guard_name' => 'web'],
            ['name' => 'post-edit', 'display_name' => 'Publicações - Editar', 'guard_name' => 'web'],
            ['name' => 'post-delete', 'display_name' => 'Publicações - Excluir', 'guard_name' => 'web'],

            ['name' => 'comment-list', 'display_name' => 'Comentários - Consultar', 'guard_name' => 'web'],
            ['name' => 'comment-create', 'display_name' => 'Comentários - Cadastrar', 'guard_name' => 'web'],
            ['name' => 'comment-edit', 'display_name' => 'Comentários - Editar', 'guard_name' => 'web'],
            ['name' => 'comment-delete', 'display_name' => 'Comentários - Excluir', 'guard_name' => 'web']

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
