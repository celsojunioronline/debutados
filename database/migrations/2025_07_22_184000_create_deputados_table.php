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
        Schema::create('deputados', function (Blueprint $table) {
            $table->comment('Tabela de Deputados');

            $table->bigInteger('id', false, true)
                ->primary()
                ->comment('ID do Deputado (Câmara)');

            $table->string('uri')->comment('URI do Deputado');
            $table->string('nome', 128)->comment('Nome do Deputado');
            $table->string('sigla_partido', 16)->comment('Sigla do Partido');
            $table->string('sigla_uf', 2)->comment('UF');
            $table->bigInteger('id_legislatura')->comment('ID da Legislatura');
            $table->string('url_foto')->comment('Foto do Deputado');
            $table->string('email')->nullable()->comment('Email (se disponível)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputados');
    }
};
