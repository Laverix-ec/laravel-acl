<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inherit_id')->unsigned()->nullable()->index()->foreign('inherit_id')->references('id')->on('permissions');
            $table->string('name')->index();
            $table->string('label')->nullable();
            $table->boolean('show_to_users')->nullable()->default(1);
            $table->json('slug');
            $table->text('description')->nullable();
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
        Schema::drop('permissions');
    }

}
