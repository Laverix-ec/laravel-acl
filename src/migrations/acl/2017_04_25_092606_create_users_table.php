<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username',45);
                $table->string('password', 255);
                $table->string('photo', 255)->nullable();
                $table->rememberToken();
                $table->boolean('changed_password')->default(false);
                $table->boolean('enabled')->default(true);
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->string('email', 75)->nullable();
                $table->string('institution', 50)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
