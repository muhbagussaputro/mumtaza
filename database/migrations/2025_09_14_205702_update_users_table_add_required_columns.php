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
        Schema::table('users', function (Blueprint $table) {
            // Update role enum to include super_admin
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin', 'guru', 'siswa'])->default('siswa');

            // Add missing columns for complete user profile
            $table->string('telepon')->nullable()->after('email');
            $table->string('foto_path')->nullable()->after('telepon');
            $table->string('orang_tua_nama')->nullable()->after('orang_tua');
            $table->string('tempat_lahir')->nullable()->after('tempat');
            $table->boolean('status_aktif')->default(true)->after('id_program');

            // Add soft deletes and timezone timestamps
            $table->softDeletes();
        });

        // Rename existing columns to match schema
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('tempat', 'tempat_lahir_old');
            $table->renameColumn('orang_tua', 'orang_tua_nama_old');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telepon',
                'foto_path',
                'orang_tua_nama',
                'tempat_lahir',
                'status_aktif',
            ]);
            $table->dropSoftDeletes();

            // Restore old role enum
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa');

            // Restore old column names
            $table->renameColumn('tempat_lahir_old', 'tempat');
            $table->renameColumn('orang_tua_nama_old', 'orang_tua');
        });
    }
};
