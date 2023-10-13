<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('admin_user_id')->unsigned()->nullable();
            $table->dateTime('log_date');
            $table->string('table_name',50)->nullable();
            $table->bigInteger('table_id')->unsigned()->nullable();
            $table->string('log_type',50);
            $table->longText('data')->nullable();
            $table->longText('before_data')->nullable();
            $table->longText('after_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
