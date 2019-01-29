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
            $table->integer('module_id')->unsigned()->nullable()->index('fk_permissions_modules_idx');
            $table->integer('inherit_id')->unsigned()->nullable()->index()->foreign('inherit_id')->references('id')->on('permissions');
            $table->string('name')->index();
            $table->string('label')->nullable();
            $table->json('slug');
            $table->text('description')->nullable();
            $table->timestamps();

            // foreign key to modules table
            $table->foreign('module_id', 'fk_permissions_modules')->references('id')->on('modules')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function(Blueprint $table)
        {
            $table->dropForeign('fk_employees_users1');
        });

        Schema::drop('permissions');
    }

}
