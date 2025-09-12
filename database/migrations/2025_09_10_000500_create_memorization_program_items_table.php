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
        Schema::create('memorization_program_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('memorization_programs')->cascadeOnDelete();
            $table->unsignedTinyInteger('juz_number'); // 1..30
            $table->string('title')->nullable(); // e.g., "Juz 1"
            $table->date('target_date')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'skipped'])->default('planned');
            $table->date('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['program_id', 'juz_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorization_program_items');
    }
};
