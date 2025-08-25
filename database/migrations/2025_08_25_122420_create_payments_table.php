<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_token')->nullable();
            $table->string('status')->default('pendiente'); // pendiente, pagado, fallido, etc.
            $table->decimal('monto', 10, 2);
            $table->string('response_code')->nullable();
            $table->string('authorization_code')->nullable();
            $table->json('response_data')->nullable(); // Para guardar respuesta completa de Transbank
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
