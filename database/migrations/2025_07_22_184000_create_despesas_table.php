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
        Schema::create('despesas', function (Blueprint $table) {
            $table->comment('Tabela de Gastos dos Deputados');

            $table->id();

            $table->unsignedBigInteger('deputado_id')->comment('Relacionamento com Deputado');
            $table->foreign('deputado_id')->references('id')->on('deputados')->onDelete('cascade');


            $table->integer('ano')->comment('Ano da despesa');
            $table->integer('mes')->comment('Mês da despesa');
            $table->string('tipo_despesa')->comment('Tipo de despesa');

            $table->integer('cod_documento')->comment('Código do documento');
            $table->string('tipo_documento', 64)->comment('Tipo do documento');
            $table->integer('cod_tipo_documento')->default(0);

            $table->dateTime('data_documento')->nullable();
            $table->string('num_documento', 32)->nullable();

            $table->integer('valor_documento')->comment('Valor total (centavos)');
            $table->string('url_documento')->nullable();

            $table->string('nome_fornecedor', 128);
            $table->string('cnpj_cpf_fornecedor', 14);

            $table->integer('valor_liquido');
            $table->integer('valor_glosa');
            $table->string('num_ressarcimento', 128)->nullable();

            $table->integer('cod_lote')->default(0);
            $table->integer('parcela')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
