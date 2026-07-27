<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard ringkas: cuma statistik, tanpa tabel penuh.
     */
    public function dashboard()
    {
        $stats = [
            'total'     => Pengajuan::count(),
            'diproses'  => Pengajuan::where('status', 'diproses')->count(),
            'selesai'   => Pengajuan::where('status', 'selesai')->count(),
            'ditolak'   => Pengajuan::where('status', 'ditolak')->count(),
        ];

        $terbaru = Pengajuan::latest('tanggal_pengajuan')->take(5)->get();

        return view('admin', compact('stats', 'terbaru'));
    }

    /**
     * Halaman Data Pengajuan: statistik + tabel lengkap + filter + pencarian.
     */
    public function pengajuanIndex(Request $request)
    {
        $status = $request->query('status', 'all');
        $cari   = $request->query('cari');

        $query = Pengajuan::query()->latest('tanggal_pengajuan');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($cari) {
            $query->where('nama_pemohon', 'like', '%' . $cari . '%');
        }

        $pengajuan = $query->paginate(10)->withQueryString();

        $stats = [
            'total'     => Pengajuan::count(),
            'diproses'  => Pengajuan::where('status', 'diproses')->count(),
            'selesai'   => Pengajuan::where('status', 'selesai')->count(),
            'ditolak'   => Pengajuan::where('status', 'ditolak')->count(),
        ];

        return view('DataPengajuan', compact('pengajuan', 'stats', 'status', 'cari'));
    }

    /**
     * Setujui / ubah status pengajuan jadi diproses atau selesai.
     */
    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $pengajuan->update(['status' => $request->status]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    /**
     * Hapus data pengajuan secara permanen.
     */
    public function destroyPengajuan(Pengajuan $pengajuan)
    {
        $pengajuan->delete();

        return back()->with('success', 'Data pengajuan berhasil dihapus.');
    }

    /**
     * Tampilkan form tambah pengajuan manual (oleh admin).
     */
    public function createPengajuan()
    {
        return view('TambahPengajuan', ['pengajuan' => new Pengajuan()]);
    }

    /**
     * Simpan pengajuan baru yang diinput manual oleh admin.
     */
    public function storePengajuan(Request $request)
    {
        $validated = $request->validate([
            'nama_pemohon'      => 'required|string|max:255',
            'jenis_surat'       => 'required|string|max:255',
            'status'            => 'required|in:menunggu,diproses,selesai,ditolak',
            'keterangan'        => 'nullable|string',
            'tanggal_pengajuan' => 'required|date',
        ]);

        $validated['no_registrasi'] = 'PGJ-' . now()->format('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));

        Pengajuan::create($validated);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Pengajuan baru berhasil ditambahkan.');
    }

    /**
     * Lihat detail satu pengajuan.
     */
    public function show(Pengajuan $pengajuan)
    {
        return view('admin-detail', compact('pengajuan'));
    }

    /**
     * Tampilkan halaman Data Pengguna.
     */
    public function pengguna()
    {
        $pengguna = \App\Models\User::orderByDesc('created_at')->get();

        // Email yang dianggap admin, samakan dengan AdminOnly middleware
        $adminEmails = (new \App\Http\Middleware\AdminOnly())->getAllowedEmails();

        $totalPengguna = $pengguna->count();
        $totalAdmin    = $pengguna->whereIn('email', $adminEmails)->count();
        $totalUser     = $totalPengguna - $totalAdmin;

        return view('admin-pengguna', compact('pengguna', 'adminEmails', 'totalPengguna', 'totalAdmin', 'totalUser'));
    }
}