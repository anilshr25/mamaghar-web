<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCustomRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_custom_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id')->index()->nullable();
            $table->unsignedBigInteger('role_id')->index()->nullable();
            $table->unsignedBigInteger('permission_id')->index()->nullable();
            $table->string('group_name')->nullable()->index()->nullable();
            $table->string('permission_name')->nullable()->index()->nullable();
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_custom_role_permissions');
    }
}
