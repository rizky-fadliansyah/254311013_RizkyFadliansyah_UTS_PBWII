<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respon', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('Id_Respon'); 
            $table->text('Respon');
            $table->timestamps();

            $table->foreign('Id_Respon')->references('Id_Ulasan')->on('ulasan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respon');
    }
};