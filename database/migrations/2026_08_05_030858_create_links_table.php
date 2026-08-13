<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi untuk membuat tabel 'links' (Katalog Buku Digital).
     */
    public function up(): void {
        Schema::create('links', function (Blueprint $table) {
            // Primary Key: ID unik bernilai integer auto-increment untuk setiap buku
            $table->id();

            // Menyimpan judul atau nama dari buku digital / novel / komik
            $table->string('title');

            // Menyimpan path/lokasi penyimpanan berkas PDF e-book di storage (menggantikan kolom 'url')
            $table->string('pdf_file');

            // Menyimpan path/lokasi file gambar sampul/cover buku (opsional/boleh kosong)
            $table->string('image')->nullable();

            // Status publikasi buku: true (aktif/terbit) atau false (draf/disembunyikan)
            $table->boolean('is_active')->default(true);

            // Pencatatan statistik total unduhan/pembukaan berkas PDF oleh pengunjung (default: 0)
            $table->integer('clicks')->default(0);

            // Membuat kolom otomatis 'created_at' (waktu dibuat) dan 'updated_at' (waktu diubah)
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (menghapus tabel 'links' jika dilakukan rollback).
     */
    public function down(): void {
        Schema::dropIfExists('links');
    }
};