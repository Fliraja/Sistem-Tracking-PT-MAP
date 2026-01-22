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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobil_id')->constrained('mobils')->onDelete('cascade');
            // $table->string('nama'); // nama sopir atau pengemudi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('tanggal_berangkat')->nullable(); // tanggal + jam
            $table->string('supplier');
            $table->string('tujuan');
            $table->integer('panjang')->nullable(); // cm
            $table->integer('lebar')->nullable();   // cm
            $table->integer('tinggi')->nullable();  // cm
            $table->integer('plus')->nullable();    // cm
            $table->decimal('volume', 8, 2)->nullable();  // m³
            $table->text('foto_berangkat')->nullable();
            $table->text('foto_sampai')->nullable();
            $table->enum('status', ['proses', 'perjalanan', 'selesai'])->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
