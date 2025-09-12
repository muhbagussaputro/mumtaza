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
        Schema::create('surahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('number')->unique(); // 1..114
            $table->string('name_ar');
            $table->string('name_id')->nullable();
            $table->string('juz')->nullable();
            $table->enum('revelation_place', ['Mekah', 'Madinah'])->nullable();
            $table->unsignedSmallInteger('ayah_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
