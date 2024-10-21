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
        Schema::create('purchase_requests_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->enum('status_barang', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('alasan_pembelian');
            $table->string('rencana_penempatan');
            $table->unsignedBigInteger('akun_anggaran_id')->nullable();
            $table->foreign('akun_anggaran_id')->references('id')->on('akun_anggaran')->cascadeOnDelete();
            $table->decimal('harga_pengajuan', 10, 2);
            $table->decimal('harga_pengajuan_total', 10, 2);
            $table->decimal('harga_pembelian', 10, 2)->nullable();
            $table->decimal('harga_total', 10, 2)->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests_detail');
    }
};
