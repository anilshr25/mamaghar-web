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
        Schema::create('adventure_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adventure_id')->index()->nullable();
            $table->foreign('adventure_id')->references('id')->on('adventures')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type')->default('image')->nullable();
            $table->integer('position')->nullable();
            $table->string('file')->nullable();
            $table->string('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adventure_galleries');
    }
};
