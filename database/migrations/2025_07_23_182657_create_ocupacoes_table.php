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
        Schema::create('ocupacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deputado_id')->constrained('deputados')->onDelete('cascade');
            $table->string('titulo');
            $table->string('entidade');
            $table->string('ano_inicio')->nullable();
            $table->string('ano_fim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocupacoes');
    }
};
