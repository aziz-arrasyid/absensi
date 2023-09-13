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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('regNumber');
            $table->string('namaLengkap');
            $table->foreignId('jabatan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bidang_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('seksi_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->longText('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
