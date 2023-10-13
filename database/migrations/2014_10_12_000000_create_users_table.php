<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('is_login_verified')->default(0)->nullable();
            $table->boolean('is_mfa_enabled')->default(0)->nullable();
            $table->boolean('is_email_authentication_enabled')->default(0)->nullable();
            $table->string('mfa_secret_code')->nullable();
            $table->string('mfa_authentication_image')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
