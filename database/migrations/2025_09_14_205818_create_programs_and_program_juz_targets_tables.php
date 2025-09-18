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
        // Create programs table
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->enum('jenis', ['reguler', 'khusus'])->comment('reguler=2 juz; khusus=custom');
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['guru_id', 'jenis']);
        });

        // Create program_juz_targets table
        Schema::create('program_juz_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->tinyInteger('juz_number')->unsigned()->comment('1-30');
            $table->timestampsTz();

            $table->unique(['program_id', 'juz_number']);
            $table->index('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_juz_targets');
        Schema::dropIfExists('programs');
    }
};
