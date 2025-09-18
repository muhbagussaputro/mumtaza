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
            // Add orang_tua_telepon column for parent phone number
            $table->string('orang_tua_telepon')->nullable()->after('orang_tua_nama');

            // Add additional fields for better user management
            $table->string('nisn')->nullable()->unique()->change();
            $table->string('nis')->nullable()->unique()->change();
            $table->enum('jenis', ['regular', 'khusus'])->nullable()->after('id_kelas');
            $table->integer('tahun_masuk')->nullable()->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'orang_tua_telepon',
                'jenis',
                'tahun_masuk',
            ]);

            // Revert unique constraints
            $table->string('nisn')->nullable()->change();
            $table->string('nis')->nullable()->change();
        });
    }
};
