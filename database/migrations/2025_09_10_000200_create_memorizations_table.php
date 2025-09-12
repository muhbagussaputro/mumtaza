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
        Schema::create('memorizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // student
            $table->foreignId('surah_id')->constrained('surahs')->cascadeOnDelete();
            $table->unsignedSmallInteger('start_ayah');
            $table->unsignedSmallInteger('end_ayah');
            $table->date('memorized_at')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'submitted', 'passed', 'failed'])->default('planned');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'surah_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorizations');
    }
};
