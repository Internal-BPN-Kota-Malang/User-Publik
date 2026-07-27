<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_registrasi',
        'nama_pemohon',
        'jenis_surat',
        'status',       // menunggu | diproses | selesai | ditolak
        'keterangan',
        'tanggal_pengajuan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];
}