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
        Schema::table('deputados', function (Blueprint $table) {
            $table->string('nome_civil')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('municipio_nascimento')->nullable();
            $table->string('uf_nascimento', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deputados', function (Blueprint $table) {
            $table->dropColumn([
                'nome_civil', 'data_nascimento', 'municipio_nascimento', 'uf_nascimento'
            ]);
        });
    }
};
