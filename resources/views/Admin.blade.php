<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Kantor Pertanahan</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f5f6fa;
    color: #222;
  }

  .app { display: flex; min-height: 100vh; }

  /* Sidebar */
  .sidebar {
    width: 250px;
    flex-shrink: 0;
    background: #1e2a3a;
    color: #cdd5df;
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    height: 100vh;
  }

  .sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 22px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    position: relative;
  }

  .sidebar-close-btn {
    display: none;
    margin-left: auto;
    width: 30px; height: 30px;
    border-radius: 8px;
    border: none;
    background: rgba(255,255,255,0.08);
    color: #fff;
    font-size: 15px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .sidebar-close-btn:hover { background: rgba(255,255,255,0.18); }

  .sidebar-brand img {
    width: 34px; height: 34px; border-radius: 50%; object-fit: cover; background: #fdf6ee;
  }

  .sidebar-brand span {
    color: #fff; font-weight: 700; font-size: 14.5px; line-height: 1.3;
  }

  .sidebar-nav {
    flex: 1;
    padding: 18px 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    overflow-y: auto;
  }

  .sidebar-section-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #6b7688;
    padding: 14px 12px 6px;
  }

  .sidebar-nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 8px;
    color: #cdd5df;
    text-decoration: none;
    font-size: 13.5px;
    font-weight: 600;
    transition: background 0.2s, color 0.2s;
  }

  .sidebar-nav a .ic { font-size: 16px; width: 20px; text-align: center; }

  .sidebar-nav a:hover { background: rgba(255,255,255,0.06); color: #fff; }

  .sidebar-nav a.active {
    background: linear-gradient(90deg, #17b8c4, #2f5a8a);
    color: #fff;
  }

  .sidebar-badge {
    margin-left: auto;
    background: #e5205a;
    color: #fff;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
  }

  .sidebar-footer {
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.08);
  }

  .sidebar-user {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sidebar-user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #17b8c4, #7b2fbe);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 13px; flex-shrink: 0;
  }

  .sidebar-user-name { font-size: 13px; font-weight: 700; color: #fff; }
  .sidebar-user-role { font-size: 11.5px; color: #8b95a5; }

  .sidebar-logout {
    display: block;
    margin-top: 12px;
    font-size: 12.5px;
    color: #e5205a;
    text-decoration: none;
    font-weight: 700;
  }
  .sidebar-logout:hover { text-decoration: underline; }

  /* Main content */
  .main {
    flex: 1;
    min-width: 0;
  }

  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    padding: 16px 28px;
    border-bottom: 1px solid #eef0f3;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .topbar h1 {
    font-size: 19px;
    font-weight: 700;
    color: #1e2a3a;
  }

  .topbar .subtitle {
    font-size: 12.5px;
    color: #8b95a5;
    margin-top: 2px;
  }

  .topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .topbar-search {
    position: relative;
  }

  .topbar-search input {
    width: 240px;
    border: 1px solid #d8dde3;
    border-radius: 8px;
    padding: 9px 12px 9px 34px;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
  }
  .topbar-search input:focus { border-color: #17b8c4; }

  .topbar-search::before {
    content: '';
    position: absolute;
    left: 12px; top: 50%; transform: translateY(-50%);
    width: 12px; height: 12px;
    border: 2px solid #9aa4af;
    border-radius: 50%;
  }

  .topbar-bell {
    position: relative;
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #f5f6fa;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    cursor: pointer;
  }
  .topbar-bell .dot {
    position: absolute; top: 8px; right: 9px;
    width: 7px; height: 7px; border-radius: 50%;
    background: #e5205a; border: 1.5px solid #fff;
  }

  .content { padding: 26px 28px 60px; }

  /* Stat cards */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 28px;
  }

  .stat-card {
    background: #fff;
    border: 1px solid #eef0f3;
    border-radius: 16px;
    padding: 20px 22px;
    box-shadow: 0 3px 14px rgba(20,30,50,0.04);
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .stat-icon {
    width: 46px; height: 46px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    color: #fff;
    flex-shrink: 0;
  }

  .stat-card:nth-child(1) .stat-icon { background: linear-gradient(135deg, #17b8c4, #0e8b95); }
  .stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, #ef9f27, #c97c0c); }
  .stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, #1d9e75, #146e52); }
  .stat-card:nth-child(4) .stat-icon { background: linear-gradient(135deg, #e24b4a, #a82f2e); }

  .stat-value { font-size: 22px; font-weight: 800; color: #1e2a3a; line-height: 1.2; }
  .stat-label { font-size: 12.5px; color: #8b95a5; margin-top: 2px; }

  /* Table card */
  .table-card {
    background: #fff;
    border: 1px solid #eef0f3;
    border-radius: 16px;
    box-shadow: 0 3px 14px rgba(20,30,50,0.04);
    overflow: hidden;
  }

  .table-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    padding: 20px 24px;
    border-bottom: 1px solid #eef0f3;
  }

  .table-card-head h2 { font-size: 16px; font-weight: 700; color: #1e2a3a; }

  .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }

  .filter-tab {
    font-size: 12.5px;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 20px;
    border: 1px solid #e2e6eb;
    background: #fff;
    color: #5a6b7d;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s, color 0.2s, border-color 0.2s;
  }

  .filter-tab.active {
    background: linear-gradient(90deg, #17b8c4, #2f5a8a);
    border-color: transparent;
    color: #fff;
  }

  table { width: 100%; border-collapse: collapse; }

  thead th {
    text-align: left;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #8b95a5;
    padding: 14px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #eef0f3;
    white-space: nowrap;
  }

  tbody td {
    padding: 16px 24px;
    font-size: 13.5px;
    color: #333;
    border-bottom: 1px solid #f2f4f7;
    vertical-align: middle;
  }

  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #f8fafc; }

  .cell-nama { font-weight: 700; color: #1e2a3a; }
  .cell-no { font-family: monospace; font-size: 12.5px; color: #7a8896; }
  .cell-jenis { color: #444; }

  .status-pill {
    display: inline-block;
    font-size: 11.5px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    white-space: nowrap;
  }

  .status-diproses { background: #faeeda; color: #854f0b; }
  .status-selesai { background: #eaf3de; color: #27500a; }
  .status-ditolak { background: #fcebeb; color: #791f1f; }
  .status-menunggu { background: #eef0f3; color: #45505c; }

  .row-actions { display: flex; gap: 8px; }

  .icon-btn {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1px solid #e2e6eb;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 13px;
    color: #5a6b7d;
    transition: background 0.2s, border-color 0.2s;
  }
  .icon-btn:hover { background: #f5f6fa; border-color: #17b8c4; color: #17b8c4; }
  .icon-btn.danger:hover { border-color: #e24b4a; color: #e24b4a; }

  .table-card-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    font-size: 12.5px;
    color: #8b95a5;
    flex-wrap: wrap;
    gap: 12px;
  }

  .pagination { display: flex; gap: 6px; }
  .pagination button {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: 1px solid #e2e6eb;
    background: #fff;
    font-size: 12.5px;
    font-weight: 700;
    color: #5a6b7d;
    cursor: pointer;
  }
  .pagination button.active {
    background: linear-gradient(90deg, #17b8c4, #2f5a8a);
    border-color: transparent;
    color: #fff;
  }

  @media (max-width: 1100px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
  }

  @media (max-width: 900px) {
    .sidebar { position: fixed; left: -260px; z-index: 200; transition: left 0.2s; }
    .sidebar.open { left: 0; }
    .hamburger-admin { display: flex !important; }
    .sidebar-close-btn { display: flex !important; }
    table { display: block; overflow-x: auto; }
  }

  .hamburger-admin {
    display: none;
    width: 36px; height: 36px;
    border-radius: 8px;
    border: 1px solid #e2e6eb;
    background: #fff;
    align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 16px;
    position: relative;
    z-index: 210;
  }

  .sidebar-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 150;
  }

  .sidebar-backdrop.show { display: block; }
</style>
</head>
<body>

<div class="app">

  <!-- Backdrop, muncul di mobile saat sidebar terbuka -->
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img src="logo.png" alt="Logo">
      <span>Kantor Pertanahan<br>Admin Panel</span>
      <button type="button" id="sidebarClose" class="sidebar-close-btn" aria-label="Tutup menu">✕</button>
    </div>

    <nav class="sidebar-nav">
      <div class="sidebar-section-label">Menu</div>
      <a href="{{ route('admin') }}" class="active"><span class="ic">📊</span> Dashboard</a>
      <a href="{{ route('admin.pengajuan.index') }}"><span class="ic">📥</span> Data Pengajuan <span class="sidebar-badge">{{ $stats['total'] ?? 0 }}</span></a>
      <a href="{{ route('admin.formulir') }}"><span class="ic">📄</span> Data Formulir</a>
      <a href="{{ route('admin.pengguna') }}"><span class="ic">👥</span> Data Pengguna</a>

      <div class="sidebar-section-label">Lainnya</div>
      <a href="#"><span class="ic">📰</span> Berita &amp; Pengumuman</a>
      <a href="#"><span class="ic">⚙️</span> Pengaturan</a>
      <a href="/"><span class="ic">🌐</span> Lihat Situs Publik</a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="sidebar-user-avatar">AD</div>
        <div>
          <div class="sidebar-user-name">Admin Loket</div>
          <div class="sidebar-user-role">Administrator</div>
        </div>
      </div>
      <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="sidebar-logout" style="background:none; border:none; cursor:pointer;">Keluar</button>
      </form>
    </div>
  </aside>

  <!-- Main -->
  <div class="main">
    <div class="topbar">
      <div style="display:flex; align-items:center; gap:14px;">
        <div class="hamburger-admin" id="hamburgerAdmin">☰</div>
        <div>
          <h1>Dashboard</h1>
          <div class="subtitle">Ringkasan pengajuan surat &amp; formulir hari ini</div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="topbar-bell">🔔<span class="dot"></span></div>
      </div>
    </div>

    <div class="content">

      @if (session('success'))
        <div style="background:#eaf3de; color:#27500a; padding:12px 18px; border-radius:10px; font-size:13.5px; font-weight:600; margin-bottom:20px;">
          {{ session('success') }}
        </div>
      @endif


      <!-- Stat cards -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon">📥</div>
          <div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Pengajuan</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">⏳</div>
          <div>
            <div class="stat-value">{{ $stats['diproses'] }}</div>
            <div class="stat-label">Sedang Diproses</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">✅</div>
          <div>
            <div class="stat-value">{{ $stats['selesai'] }}</div>
            <div class="stat-label">Selesai</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">✕</div>
          <div>
            <div class="stat-value">{{ $stats['ditolak'] }}</div>
            <div class="stat-label">Ditolak</div>
          </div>
        </div>
      </div>

      <!-- Ringkasan pengajuan terbaru -->
      <div class="table-card">
        <div class="table-card-head">
          <h2>Pengajuan Terbaru</h2>
          <a href="{{ route('admin.pengajuan.index') }}" class="btn-primary" style="background: linear-gradient(90deg, #17b8c4, #2f5a8a); color:#fff; border:none; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none;">Lihat Semua →</a>
        </div>

        <table>
          <thead>
            <tr>
              <th>No. Registrasi</th>
              <th>Nama Pemohon</th>
              <th>Jenis Surat</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($terbaru as $item)
            <tr>
              <td class="cell-no">{{ $item->no_registrasi }}</td>
              <td class="cell-nama">{{ $item->nama_pemohon }}</td>
              <td class="cell-jenis">{{ $item->jenis_surat }}</td>
              <td>{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
              <td>
                <span class="status-pill status-{{ $item->status }}">
                  @switch($item->status)
                    @case('menunggu') Menunggu Verifikasi @break
                    @case('diproses') Diproses @break
                    @case('selesai') Selesai @break
                    @case('ditolak') Ditolak @break
                  @endswitch
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" style="text-align:center; padding:40px; color:#8b95a5;">Belum ada data pengajuan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

    </div>
  </div>
</div>

<script>
  // Toggle sidebar mobile: buka via hamburger, tutup via tombol X atau klik backdrop
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebarBackdrop');

  function openSidebar() {
    sidebar.classList.add('open');
    backdrop.classList.add('show');
  }

  function closeSidebar() {
    sidebar.classList.remove('open');
    backdrop.classList.remove('show');
  }

  document.getElementById('hamburgerAdmin').addEventListener('click', () => {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
  });

  document.getElementById('sidebarClose').addEventListener('click', closeSidebar);
  backdrop.addEventListener('click', closeSidebar);

</script>

</body>
</html>