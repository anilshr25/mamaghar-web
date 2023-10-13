<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('album_id')->unsigned()->index()->nullable();
            $table->foreign('album_id')->on('albums')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->string("title")->nullable();
            $table->string("path")->nullable();
            $table->integer('position')->nullable();
            $table->boolean("is_featured")->default(0);
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
        Schema::dropIfExists('album_values');
    }
}
