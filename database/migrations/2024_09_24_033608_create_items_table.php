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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('akun_anggaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_akun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('akun_anggaran');
    }
};
