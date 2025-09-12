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
        Schema::table('memorizations', function (Blueprint $table) {
            $table->foreignId('program_id')
                ->nullable()
                ->after('surah_id')
                ->constrained('memorization_programs')
                ->nullOnDelete();
            $table->index(['program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memorizations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_id');
            $table->dropIndex(['program_id']);
        });
    }
};
