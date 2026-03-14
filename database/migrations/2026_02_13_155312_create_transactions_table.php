<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk')
                ->constrained('products')
                ->onDelete('cascade');
            $table->string('nama_pelanggan', 45);
            $table->string('nomor_unik', 10);
            $table->integer('uang_bayar');
            $table->integer('uang_kembali');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
