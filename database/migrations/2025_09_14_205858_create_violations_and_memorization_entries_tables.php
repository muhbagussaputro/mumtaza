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
        // Create violations table (master)
        Schema::create('violations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestampsTz();
        });

        // Create memorization_entries table (catatan hafalan/setoran)
        Schema::create('memorization_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();

            // Materi
            $table->tinyInteger('juz_number')->unsigned()->comment('1-30');
            $table->foreignId('surah_id')->nullable()->constrained('surahs')->nullOnDelete();
            $table->smallInteger('halaman')->unsigned()->nullable();
            $table->smallInteger('ayat')->unsigned()->nullable();

            // Kegiatan & penilaian
            $table->enum('jadwal_setoran', ['pagi', 'siang', 'malam']);
            $table->enum('jenis_setoran', ['tambah_hafalan', 'murojaah_qorib', 'murojaah_bid']);
            $table->enum('keterangan', ['lancar', 'tidak_lancar']);
            $table->enum('klasifikasi', ['tercapai', 'tidak_tercapai']);
            $table->boolean('hadir')->default(true);

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['student_id', 'program_id', 'juz_number', 'created_at'], 'mem_entries_main_idx');
            $table->index(['guru_id', 'created_at'], 'mem_entries_guru_idx');
        });

        // Create memorization_entry_violations table (pivot N-M)
        Schema::create('memorization_entry_violations', function (Blueprint $table) {
            $table->foreignId('entry_id')->constrained('memorization_entries')->cascadeOnDelete();
            $table->foreignId('violation_id')->constrained('violations')->cascadeOnDelete();

            $table->primary(['entry_id', 'violation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorization_entry_violations');
        Schema::dropIfExists('memorization_entries');
        Schema::dropIfExists('violations');
    }
};
