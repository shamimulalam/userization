<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('permission_id')->nullable();
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->unsignedInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unique(['role_id', 'permission_id']);
            $table->enum('status',array('Active', 'Inactive'))->default('Active');
            $table->softDeletes();
            $table->unsignedInteger('created_by',false)->default(0);
            $table->unsignedInteger('updated_by',false)->nullable();
            $table->timestamps();
        });
        DB::unprepared(file_get_contents("database/seeds/RolePermissionTableSeeder.php"));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
}
