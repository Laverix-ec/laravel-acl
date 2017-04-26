<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index()->foreign()->references("id")->on("acl_roles")->onDelete("cascade");
            $table->integer('user_id')->unsigned()->index()->foreign()->references("id")->on("acl_users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acl_role_user');
    }

}
