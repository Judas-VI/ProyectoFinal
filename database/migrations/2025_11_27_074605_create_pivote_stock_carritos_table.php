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
        Schema::create('pivote_stock_carritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained();
            $table->foreignId('stock_id')->constrained();
            $table->float('precio')->unsigned();
            $table->integer('cantidad');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivote_stock_carritos');
    }
};
