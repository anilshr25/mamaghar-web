<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('link')->nullable();
            $table->string('heading_text')->nullable();
            $table->string('sub_heading_text')->nullable();
            $table->boolean('show_button')->default(0)->nullable();
            $table->string('button_text')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('position')->nullable();
            $table->boolean('new_tab')->default(0)->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
