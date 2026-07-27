<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Formulir - Admin</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f6fa; color: #222; }

  .app { display: flex; min-height: 100vh; }

  /* Sidebar */
  .sidebar {
    width: 250px; flex-shrink: 0; background: #1e2a3a; color: #cdd5df;
    display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh;
  }
  .sidebar-brand { display: flex; align-items: center; gap: 10px; padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); position: relative; }
  .sidebar-brand img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; background: #fdf6ee; }
  .sidebar-brand span { color: #fff; font-weight: 700; font-size: 14.5px; line-height: 1.3; }
  .sidebar-close-btn { display: none; margin-left: auto; width: 30px; height: 30px; border-radius: 8px; border: none; background: rgba(255,255,255,0.08); color: #fff; font-size: 15px; cursor: pointer; align-items: center; justify-content: center; flex-shrink: 0; }
  .sidebar-close-btn:hover { background: rgba(255,255,255,0.18); }
  .sidebar-nav { flex: 1; padding: 18px 12px; display: flex; flex-direction: column; gap: 4px; overflow-y: auto; }
  .sidebar-section-label { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #6b7688; padding: 14px 12px 6px; }
  .sidebar-nav a { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 8px; color: #cdd5df; text-decoration: none; font-size: 13.5px; font-weight: 600; transition: background 0.2s, color 0.2s; }
  .sidebar-nav a .ic { font-size: 16px; width: 20px; text-align: center; }
  .sidebar-nav a:hover { background: rgba(255,255,255,0.06); color: #fff; }
  .sidebar-nav a.active { background: linear-gradient(90deg, #17b8c4, #2f5a8a); color: #fff; }
  .sidebar-badge { margin-left: auto; background: #e5205a; color: #fff; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 10px; }
  .sidebar-footer { padding: 16px; border-top: 1px solid rgba(255,255,255,0.08); }
  .sidebar-user { display: flex; align-items: center; gap: 10px; }
  .sidebar-user-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #17b8c4, #7b2fbe); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 13px; flex-shrink: 0; }
  .sidebar-user-name { font-size: 13px; font-weight: 700; color: #fff; }
  .sidebar-user-role { font-size: 11.5px; color: #8b95a5; }
  .sidebar-logout { display: block; margin-top: 12px; font-size: 12.5px; color: #e5205a; text-decoration: none; font-weight: 700; }
  .sidebar-logout:hover { text-decoration: underline; }

  /* Main content */
  .main { flex: 1; min-width: 0; }
  .topbar { display: flex; align-items: center; justify-content: space-between; background: #fff; padding: 16px 28px; border-bottom: 1px solid #eef0f3; position: sticky; top: 0; z-index: 10; }
  .topbar h1 { font-size: 19px; font-weight: 700; color: #1e2a3a; }
  .topbar .subtitle { font-size: 12.5px; color: #8b95a5; margin-top: 2px; }
  .topbar-right { display: flex; align-items: center; gap: 16px; }
  .topbar-search { position: relative; }
  .topbar-search input { width: 240px; border: 1px solid #d8dde3; border-radius: 8px; padding: 9px 12px 9px 34px; font-size: 13px; outline: none; transition: border-color 0.2s; }
  .topbar-search input:focus { border-color: #17b8c4; }
  .topbar-search::before { content: ''; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 12px; height: 12px; border: 2px solid #9aa4af; border-radius: 50%; }

  .btn-primary {
    background: linear-gradient(90deg, #17b8c4, #2f5a8a);
    color: #fff; border: none; padding: 10px 18px; border-radius: 8px;
    font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; transition: filter 0.2s, transform 0.15s;
  }
  .btn-primary:hover { filter: brightness(1.06); transform: translateY(-1px); }

  .content { padding: 26px 28px 60px; }

  .table-card { background: #fff; border: 1px solid #eef0f3; border-radius: 16px; box-shadow: 0 3px 14px rgba(20,30,50,0.04); overflow: hidden; }
  .table-card-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; padding: 20px 24px; border-bottom: 1px solid #eef0f3; }
  .table-card-head h2 { font-size: 16px; font-weight: 700; color: #1e2a3a; }
  .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
  .filter-tab { font-size: 12.5px; font-weight: 700; padding: 8px 14px; border-radius: 20px; border: 1px solid #e2e6eb; background: #fff; color: #5a6b7d; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s, color 0.2s, border-color 0.2s; }
  .filter-tab.active { background: linear-gradient(90deg, #17b8c4, #2f5a8a); border-color: transparent; color: #fff; }

  table { width: 100%; border-collapse: collapse; }
  thead th { text-align: left; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #8b95a5; padding: 14px 24px; background: #f8fafc; border-bottom: 1px solid #eef0f3; white-space: nowrap; }
  tbody td { padding: 16px 24px; font-size: 13.5px; color: #333; border-bottom: 1px solid #f2f4f7; vertical-align: middle; }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #f8fafc; }

  .cell-nama { font-weight: 700; color: #1e2a3a; }
  .cell-icon { display: flex; align-items: center; gap: 12px; }
  .form-icon { width: 36px; height: 36px; border-radius: 10px; background: #eaf0f8; color: #2f5a8a; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }

  .badge-kategori { display: inline-block; font-size: 11px; font-weight: 700; color: #2f5a8a; background: #eaf0f8; padding: 3px 10px; border-radius: 20px; }

  .status-toggle { display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; font-weight: 700; }
  .status-dot { width: 8px; height: 8px; border-radius: 50%; }
  .status-aktif .status-dot { background: #1d9e75; }
  .status-aktif { color: #1d9e75; }
  .status-nonaktif .status-dot { background: #9aa4af; }
  .status-nonaktif { color: #9aa4af; }

  .row-actions { display: flex; gap: 8px; }
  .icon-btn { width: 30px; height: 30px; border-radius: 7px; border: 1px solid #e2e6eb; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 13px; color: #5a6b7d; transition: background 0.2s, border-color 0.2s; text-decoration: none; }
  .icon-btn:hover { background: #f5f6fa; border-color: #17b8c4; color: #17b8c4; }
  .icon-btn.danger:hover { border-color: #e24b4a; color: #e24b4a; }

  @media (max-width: 900px) {
    .sidebar { position: fixed; left: -260px; z-index: 200; transition: left 0.2s; }
    .sidebar.open { left: 0; }
    .hamburger-admin { display: flex !important; }
    .sidebar-close-btn { display: flex !important; }
    table { display: block; overflow-x: auto; }
    .topbar-search { display: none; }
  }

  .hamburger-admin { display: none; width: 36px; height: 36px; border-radius: 8px; border: 1px solid #e2e6eb; background: #fff; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; position: relative; z-index: 210; }

  .sidebar-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 150; }
  .sidebar-backdrop.show { display: block; }
</style>
</head>
<body>

<div class="app">

  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img src="logo.png" alt="Logo">
      <span>Kantor Pertanahan<br>Admin Panel</span>
      <button type="button" id="sidebarClose" class="sidebar-close-btn" aria-label="Tutup menu">✕</button>
    </div>

    <nav class="sidebar-nav">
      <div class="sidebar-section-label">Menu</div>
      <a href="{{ route('admin') }}"><span class="ic">📊</span> Dashboard</a>
      <a href="{{ route('admin') }}"><span class="ic">📥</span> Data Pengajuan</a>
      <a href="{{ route('admin.formulir') }}" class="active"><span class="ic">📄</span> Upload Formulir</a>
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

  <div class="main">
    <div class="topbar">
      <div style="display:flex; align-items:center; gap:14px;">
        <div class="hamburger-admin" id="hamburgerAdmin">☰</div>
        <div>
          <h1>Upload Formulir</h1>
          <div class="subtitle">Kelola daftar jenis surat &amp; formulir yang tersedia di situs publik</div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="topbar-search">
          <input type="text" id="cariFormulir" placeholder="Cari nama formulir..." value="{{ $cari ?? '' }}">
        </div>
      </div>
    </div>

    <div class="content">

      @if (session('success'))
        <div style="background:#eaf3de; color:#27500a; padding:12px 18px; border-radius:10px; font-size:13.5px; font-weight:600; margin-bottom:20px;">
          {{ session('success') }}
        </div>
      @endif

      <div class="table-card">
        <div class="table-card-head">
          <h2>Daftar Formulir</h2>
          <a href="{{ route('admin.formulir.create') }}" class="btn-primary">+ Tambah Formulir</a>
        </div>

        <table>
          <thead>
            <tr>
              <th>Formulir</th>
              <th>Kategori</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabelFormulir">
            @forelse ($formulir as $item)
            <tr data-nama="{{ strtolower($item->nama) }}">
              <td class="cell-icon"><span class="form-icon">{{ $item->icon ?? '📄' }}</span> <span class="cell-nama">{{ $item->nama }}</span></td>
              <td><span class="badge-kategori">{{ $item->kategori }}</span></td>
              <td>
                @if ($item->aktif)
                  <span class="status-toggle status-aktif"><span class="status-dot"></span> Aktif</span>
                @else
                  <span class="status-toggle status-nonaktif"><span class="status-dot"></span> Nonaktif</span>
                @endif
              </td>
              <td class="row-actions">
                <a href="{{ route('admin.formulir.edit', $item) }}" class="icon-btn" title="Edit">✏️</a>
                <form action="{{ route('admin.formulir.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus formulir \'{{ $item->nama }}\'?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="icon-btn danger" title="Hapus">🗑️</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" style="text-align:center; padding:40px; color:#8b95a5;">Belum ada data formulir. Klik "+ Tambah Formulir" untuk menambahkan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebarBackdrop');
  function openSidebar() { sidebar.classList.add('open'); backdrop.classList.add('show'); }
  function closeSidebar() { sidebar.classList.remove('open'); backdrop.classList.remove('show'); }
  document.getElementById('hamburgerAdmin').addEventListener('click', () => {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
  });
  document.getElementById('sidebarClose').addEventListener('click', closeSidebar);
  backdrop.addEventListener('click', closeSidebar);

  const cariInput = document.getElementById('cariFormulir');
  let cariTimeout;
  cariInput.addEventListener('input', () => {
    clearTimeout(cariTimeout);
    cariTimeout = setTimeout(() => {
      const url = new URL(window.location.href);
      url.searchParams.set('cari', cariInput.value);
      window.location.href = url.toString();
    }, 600);
  });
</script>

</body>
</html>