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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('Id_Ulasan');
            
            $table->foreignId('Id_Penjual')
                  ->constrained('penjual', 'Id_Penjual')
                  ->onDelete('cascade');

            $table->string('Nama_Pembeli', 100);
            $table->string('Ulasan', 250);
            $table->unsignedInteger('Rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
