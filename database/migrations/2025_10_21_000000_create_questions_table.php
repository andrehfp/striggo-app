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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->unique();
            $table->text('enunciado');
            $table->text('opcao_a');
            $table->text('opcao_b');
            $table->text('opcao_c');
            $table->text('opcao_d');
            $table->char('resposta_correta', 1); // A, B, C ou D
            $table->string('categoria')->default('Geral');
            $table->string('prova_tipo')->default('tipo_1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
