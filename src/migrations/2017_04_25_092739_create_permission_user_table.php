<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acl_permission_user', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('permission_id')->unsigned()->index()->references('id')->on('acl_permissions')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->index()->references('id')->on('acl_users')->onDelete('cascade');
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
		Schema::drop('acl_permission_user');
	}

}
