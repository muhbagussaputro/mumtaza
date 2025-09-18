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
        // Create classes table
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('tahun_ajaran');
            $table->timestampsTz();
            $table->softDeletes();
        });

        // Create class_student_histories table
        Schema::create('class_student_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('tahun_ajaran');
            $table->boolean('active')->default(true);
            $table->timestampsTz();

            $table->index(['student_id', 'class_id', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_student_histories');
        Schema::dropIfExists('classes');
    }
};
