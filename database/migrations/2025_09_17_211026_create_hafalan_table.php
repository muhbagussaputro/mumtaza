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
        Schema::create('hafalan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_program_siswa');
            $table->enum('waktu', ['pagi', 'sore', 'malam']);
            $table->enum('kehadiran', ['hadir', 'izin']);
            $table->unsignedBigInteger('id_surat');
            $table->string('ayat_mulai');
            $table->string('ayat_selesai');
            $table->enum('jenis_hafalan', ['Tambah hafalan', 'Murojaah Qorib', 'Murojaah Bid']);
            $table->enum('target', ['tercapai', 'tidak tercapai']);
            $table->enum('keterangan', ['lancar', 'tidak lancar']);
            $table->text('komentar')->nullable();
            $table->enum('pelanggaran', ['ya', 'tidak']);
            $table->text('ket_pelanggaran')->nullable();
            $table->string('halaman')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('id_program_siswa')->references('id')->on('student_programs')->onDelete('cascade');
            $table->foreign('id_surat')->references('id')->on('surahs')->onDelete('cascade');

            // Indexes for better performance
            $table->index(['id_program_siswa', 'waktu']);
            $table->index(['id_surat']);
            $table->index(['target']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalan');
    }
};
