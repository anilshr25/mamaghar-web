<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->index()->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type')->default('image')->nullable();
            $table->integer('position')->nullable();
            $table->string('file')->nullable();
            $table->string('is_active')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_galleries');
    }
};
