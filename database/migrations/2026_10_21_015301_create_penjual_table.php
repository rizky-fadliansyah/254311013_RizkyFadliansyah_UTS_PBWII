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
        Schema::create('penjual', function (Blueprint $table) {
            $table->id('Id_Penjual');

            $table->unsignedBigInteger('Id_Kategori')->nullable();
            $table->foreign('Id_Kategori')->references('Id_Kategori')->on('kategoris')->onDelete('set null');

            $table->string('Nama_Penjual', 100);
            $table->string('Deskripsi', 255);
            $table->string('Alamat_Penjual', 255);
            $table->string('No_Telp_Penjual', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjual');
    }
};
