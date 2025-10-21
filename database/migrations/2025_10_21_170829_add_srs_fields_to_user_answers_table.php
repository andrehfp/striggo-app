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
        Schema::table('user_answers', function (Blueprint $table) {
            // Spaced Repetition System fields
            $table->timestamp('next_review_at')->nullable()->after('xp_earned');
            $table->integer('repetition_number')->default(0)->after('next_review_at');
            $table->decimal('easiness_factor', 3, 2)->default(2.5)->after('repetition_number');
            $table->integer('interval_days')->default(1)->after('easiness_factor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropColumn(['next_review_at', 'repetition_number', 'easiness_factor', 'interval_days']);
        });
    }
};
