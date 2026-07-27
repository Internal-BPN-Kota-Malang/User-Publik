<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulirs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori');
            $table->string('icon', 10)->default('📄');
            $table->boolean('aktif')->default(true);
            $table->text('deskripsi')->nullable();
            $table->string('link_isi_online')->nullable();
            $table->string('file_kosong')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulirs');
    }
};