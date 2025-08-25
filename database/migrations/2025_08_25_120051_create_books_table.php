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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('categoria');
            $table->enum('tipo', ['fisico', 'ebook']);
            $table->decimal('precio', 10, 2);
            $table->string('imagen');
            $table->string('editorial');
            $table->string('autor');
            $table->string('isbn');
            $table->integer('paginas');
            $table->string('idioma');
            $table->string('fecha_publicacion');
            $table->string('formato');
            $table->string('dimensiones');
            $table->string('peso');
            $table->integer('stock');
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('reviews')->nullable();
            $table->json('generos')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
