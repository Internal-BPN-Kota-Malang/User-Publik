<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;

class AdminFormulirController extends Controller
{
    /**
     * Tampilkan daftar semua formulir.
     */
    public function index(Request $request)
    {
        $cari = $request->query('cari');

        $query = Formulir::query()->orderBy('nama');

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%');
        }

        $formulir = $query->get();

        return view('AdminFormulir', compact('formulir', 'cari'));
    }

    /**
     * Tampilkan form tambah formulir baru.
     */
    public function create()
    {
        return view('TambahFormulir', [
            'formulir' => new Formulir(),
            'mode' => 'tambah',
        ]);
    }

    /**
     * Simpan formulir baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        if ($request->hasFile('file_kosong')) {
            $validated['file_kosong'] = $request->file('file_kosong')->store('formulir', 'public');
        }

        Formulir::create($validated);

        return redirect()
            ->route('admin.formulir')
            ->with('success', 'Formulir baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit formulir.
     */
    public function edit(Formulir $formulir)
    {
        return view('TambahFormulir', [
            'formulir' => $formulir,
            'mode' => 'edit',
        ]);
    }

    /**
     * Simpan perubahan formulir.
     */
    public function update(Request $request, Formulir $formulir)
    {
        $validated = $this->validateData($request);

        if ($request->hasFile('file_kosong')) {
            // Hapus file lama kalau ada, biar storage nggak numpuk file nggak kepakai
            if ($formulir->file_kosong) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($formulir->file_kosong);
            }
            $validated['file_kosong'] = $request->file('file_kosong')->store('formulir', 'public');
        } else {
            // Nggak upload file baru → pertahankan file lama
            unset($validated['file_kosong']);
        }

        $formulir->update($validated);

        return redirect()
            ->route('admin.formulir')
            ->with('success', 'Formulir berhasil diperbarui.');
    }

    /**
     * Hapus formulir.
     */
    public function destroy(Formulir $formulir)
    {
        $formulir->delete();

        return redirect()
            ->route('admin.formulir')
            ->with('success', 'Formulir berhasil dihapus.');
    }

    /**
     * Aturan validasi untuk store & update.
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama'             => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'icon'             => 'nullable|string|max:10',
            'aktif'            => 'nullable|boolean',
            'deskripsi'        => 'nullable|string',
            'link_isi_online'  => 'nullable|string|max:255',
            'file_kosong'      => 'nullable|file|mimes:pdf|max:5120',
        ]) + ['aktif' => $request->boolean('aktif')];
    }
}