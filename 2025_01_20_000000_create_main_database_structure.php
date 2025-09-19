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
        // 1. Tabel Users - Pengguna sistem
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa');
            $table->string('foto_profil')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['role', 'status_aktif']);
            $table->index('class_id');
        });

        // 2. Tabel Classes - Kelas
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_kelas'); // Alias untuk nama
            $table->string('tahun_ajaran');
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tahun_ajaran');
        });

        // 3. Tabel Class Student Histories - Riwayat kelas siswa
        Schema::create('class_student_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->string('tahun_ajaran');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->unique(['student_id', 'class_id', 'tahun_ajaran']);
            $table->index(['student_id', 'active']);
        });

        // 4. Tabel Gurus - Data guru terpisah
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto_profil')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('telepon')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });

        // 3. Tabel Siswas - Data siswa
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nisn')->unique();
            $table->string('nis')->unique();
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->enum('jenis', ['regular', 'khusus'])->default('regular');
            $table->year('tahun_masuk');
            $table->enum('status', ['aktif', 'non_aktif', 'lulus', 'pindah'])->default('aktif');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('telepon_orang_tua')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kelas')->references('id')->on('classes')->onDelete('set null');
            $table->index(['status', 'jenis']);
            $table->index('id_kelas');
        });

        // 6. Tabel Programs - Program hafalan
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_program'); // Alias untuk nama
            $table->enum('jenis', ['tahfidz', 'tahsin', 'murojaah'])->default('tahfidz');
            $table->unsignedBigInteger('guru_id');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('guru_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['jenis', 'status']);
            $table->index('guru_id');
        });

        // 6. Tabel Student Programs - Relasi siswa dengan program
        Schema::create('student_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('program_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->decimal('progress_cached', 5, 2)->default(0);
            $table->decimal('progress', 5, 2)->default(0); // Alias untuk progress_cached
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->unique(['student_id', 'program_id']);
            $table->index('student_id');
            $table->index('program_id');
        });

        // 8. Tabel Juz Targets - Target juz per program
        Schema::create('juz_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->integer('juz_number');
            $table->integer('target_pages')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->unique(['program_id', 'juz_number']);
            $table->index('program_id');
        });

        // 9. Tabel Surahs - Data surah Al-Qur'an
        Schema::create('surahs', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('name_ar');
            $table->string('name_id');
            $table->string('name_en');
            $table->enum('revelation_place', ['mecca', 'medina']);
            $table->integer('ayah_count');
            $table->timestamps();

            $table->index('number');
        });

        // 10. Tabel Violations - Data pelanggaran
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 11. Tabel Memorization Entries - Entri hafalan siswa
        Schema::create('memorization_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->integer('juz_number')->nullable();
            $table->unsignedBigInteger('surah_id');
            $table->integer('halaman_from')->nullable();
            $table->integer('halaman_to')->nullable();
            $table->integer('ayat_from');
            $table->integer('ayat_to');
            $table->enum('jadwal', ['pagi', 'siang', 'malam'])->nullable();
            $table->enum('jenis_setoran', ['tambah_hafalan', 'murojaah_qorib', 'murojaah_bid'])->default('tambah_hafalan');
            $table->enum('keterangan', ['Lulus', 'Mengulang', 'Belum Dinilai'])->default('Belum Dinilai');
            $table->enum('klasifikasi', ['tercapai', 'belum_tercapai'])->default('belum_tercapai');
            $table->enum('status_hafalan', ['lancar', 'kurang_lancar', 'tidak_lancar'])->default('lancar');
            $table->boolean('hadir')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('surah_id')->references('id')->on('surahs')->onDelete('cascade');

            $table->index(['student_id', 'program_id']);
            $table->index(['guru_id', 'jadwal']);
            $table->index(['jenis_setoran', 'klasifikasi']);
            $table->index('surah_id');
        });

        // 12. Tabel Memorization Entry Violations - Relasi hafalan dengan pelanggaran
        Schema::create('memorization_entry_violations', function (Blueprint $table) {
            $table->unsignedBigInteger('entry_id');
            $table->unsignedBigInteger('violation_id');

            $table->foreign('entry_id')->references('id')->on('memorization_entries')->onDelete('cascade');
            $table->foreign('violation_id')->references('id')->on('violations')->onDelete('cascade');

            $table->primary(['entry_id', 'violation_id']);
        });

        // 13. Tabel Hafalan - Model hafalan lama yang masih digunakan
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_program_siswa');
            $table->enum('waktu', ['pagi', 'siang', 'malam'])->nullable();
            $table->enum('kehadiran', ['hadir', 'tidak_hadir'])->default('hadir');
            $table->unsignedBigInteger('id_surat');
            $table->integer('ayat_mulai');
            $table->integer('ayat_selesai');
            $table->enum('jenis_hafalan', ['tambah', 'murojaah_qorib', 'murojaah_bid'])->default('tambah');
            $table->enum('target', ['lancar', 'kurang_lancar', 'tidak_lancar'])->default('lancar');
            $table->text('keterangan')->nullable();
            $table->text('komentar')->nullable();
            $table->text('pelanggaran')->nullable();
            $table->text('ket_pelanggaran')->nullable();
            $table->integer('halaman')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_program_siswa')->references('id')->on('student_programs')->onDelete('cascade');
            $table->foreign('id_surat')->references('id')->on('surahs')->onDelete('cascade');

            $table->index(['id_program_siswa', 'waktu']);
            $table->index(['jenis_hafalan', 'target']);
            $table->index('id_surat');
        });

        // 14. Tabel Cache - Laravel cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // 15. Tabel Jobs - Laravel queue
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // 16. Tabel Sessions - Laravel sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 17. Tabel Password Reset Tokens - Laravel auth
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('hafalan');
        Schema::dropIfExists('memorization_entry_violations');
        Schema::dropIfExists('memorization_entries');
        Schema::dropIfExists('violations');
        Schema::dropIfExists('surahs');
        Schema::dropIfExists('juz_targets');
        Schema::dropIfExists('student_programs');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('siswas');
        Schema::dropIfExists('gurus');
        Schema::dropIfExists('class_student_histories');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('users');
    }
};
