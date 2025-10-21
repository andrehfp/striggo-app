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
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('xp')->default(0);
            $table->integer('level')->default(1);
            $table->integer('streak_days')->default(0);
            $table->date('last_study_date')->nullable();
            $table->integer('daily_goal')->default(10);
            $table->integer('questions_today')->default(0);
            $table->integer('total_questions_answered')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
