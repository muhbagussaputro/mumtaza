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
        Schema::create('memorization_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorization_id')->constrained('memorizations')->cascadeOnDelete();
            $table->foreignId('evaluator_id')->nullable()->constrained('users')->nullOnDelete(); // teacher/ustadz
            $table->date('evaluated_at')->nullable();

            // Scoring
            $table->unsignedTinyInteger('accuracy_score')->nullable(); // 0-100
            $table->unsignedTinyInteger('tajwid_score')->nullable();   // 0-100
            $table->unsignedTinyInteger('fluency_score')->nullable();  // 0-100
            $table->unsignedTinyInteger('memorization_score')->nullable(); // 0-100
            $table->unsignedTinyInteger('overall_score')->nullable(); // 0-100

            // Details
            $table->unsignedSmallInteger('mistake_count')->default(0);
            $table->text('remarks')->nullable();
            $table->enum('result', ['passed', 'revision', 'failed'])->nullable();

            $table->timestamps();

            $table->index(['memorization_id', 'evaluator_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorization_evaluations');
    }
};
