<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Pengajuan - Admin</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f6fa; color: #222; padding: 40px 20px; }

  .card {
    max-width: 640px;
    margin: 0 auto;
    background: #fff;
    border: 1px solid #eef0f3;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(20,30,50,0.05);
    padding: 32px;
  }

  .back { font-size: 13px; color: #17b8c4; text-decoration: none; font-weight: 700; display: inline-block; margin-bottom: 20px; }
  .back:hover { text-decoration: underline; }

  h1 { font-size: 20px; color: #1e2a3a; margin-bottom: 20px; }

  .row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f2f4f7; font-size: 14px; }
  .row:last-child { border-bottom: none; }
  .row span:first-child { color: #7a8896; }
  .row span:last-child { font-weight: 600; color: #222; }

  .status-pill {
    display: inline-block; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px;
  }
  .status-menunggu { background: #eef0f3; color: #45505c; }
  .status-diproses { background: #faeeda; color: #854f0b; }
  .status-selesai { background: #eaf3de; color: #27500a; }
  .status-ditolak { background: #fcebeb; color: #791f1f; }
</style>
</head>
<body>

<div class="card">
  <a href="{{ route('admin') }}" class="back">← Kembali ke dashboard</a>
  <h1>Detail Pengajuan</h1>

  <div class="row"><span>No. Registrasi</span><span>{{ $pengajuan->no_registrasi }}</span></div>
  <div class="row"><span>Nama Pemohon</span><span>{{ $pengajuan->nama_pemohon }}</span></div>
  <div class="row"><span>Jenis Surat</span><span>{{ $pengajuan->jenis_surat }}</span></div>
  <div class="row"><span>Tanggal Pengajuan</span><span>{{ $pengajuan->tanggal_pengajuan->format('d M Y') }}</span></div>
  <div class="row">
    <span>Status</span>
    <span class="status-pill status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span>
  </div>
  <div class="row"><span>Keterangan</span><span>{{ $pengajuan->keterangan ?? '-' }}</span></div>
</div>

</body>
</html>