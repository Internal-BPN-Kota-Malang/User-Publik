<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->string('nama_pemohon');
            $table->string('jenis_surat');
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pengajuan');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};