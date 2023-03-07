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
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marca_id');
            $table->string('nome', 30);
            $table->string('imagem', 30);
            $table->integer('numero_de_portas');
            $table->integer('lugares');
            $table->tinyInteger('air_bag');
            $table->tinyInteger('abs');
            $table->timestamps();

            // relacionamentos 
            $table->foreign('marca_id')->references('id')->on('marcas')->onDeleteCascade();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelos');
    }
};
