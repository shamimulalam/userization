<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['role_id', 'user_id']);
            $table->enum('status',array('Active', 'Inactive'))->default('Active');
            $table->softDeletes();
            $table->unsignedInteger('created_by',false)->default(0);
            $table->unsignedInteger('updated_by',false)->nullable();
            $table->timestamps();
        });
        Artisan::call('db:seed', [
            '--class' =>RoleUserTableSeeder::class,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
