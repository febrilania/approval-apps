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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requestor_id');
            $table->foreign('requestor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('status_berkas', ['pending', 'approved', 'rejected', 'draft', 'process'])->default('draft');
            $table->string('file_nota')->nullable();
            $table->decimal('pengajuan', 10, 2)->default(0);
            $table->decimal('pembelian', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
