<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakulikuler;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class EkstrakulikulerController extends Controller
{
    public function index()
    {
       $ekstrakulikuler = Ekstrakulikuler::with('guru')->latest()->get();

       return view('admin.ekstrakulikuler.index', compact('ekstrakulikuler'));
    }

    public function addEdit($id = null)
    {
        try {
            $ekstrakurikuler = $id
                ? Ekstrakulikuler::findOrFail(Crypt::decrypt($id))
                : null;

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ekstrakulikuler.index')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $guru = Guru::orderBy('nama_guru', 'asc')->get();

        return view('admin.ekstrakulikuler.form', compact('ekstrakulikuler', 'guru'));
    }

    /**
     * Menyimpan data baru atau perubahan ekstrakurikuler.
     */
    public function save(Request $request, $id = null)
    {
        // Jika ada ID, berarti sedang mengubah data.
        if ($id) {
            try {
                $id = Crypt::decrypt($id);
                $ekstrakulikuler = Ekstrakulikuler::findOrFail($id);

            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.ekstrakulikuler.index')
                    ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
            }

        } else {
            // Jika tidak ada ID, berarti menambah data baru.
            $ekstrakulikuler = new Ekstrakulikuler();
        }

        // Validasi input
        $request->validate([
            'nama_ekskul'    => 'required|string|max:40',
            'id_guru'        => 'required|exists:guru,id',
            'jadwal_latihan' => 'required|string|max:40',
            'deskripsi'      => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_ekskul.required'    => 'Nama ekstrakurikuler wajib diisi.',
            'nama_ekskul.max'         => 'Nama ekstrakurikuler maksimal 40 karakter.',
            'id_guru.required'        => 'Guru pembina wajib dipilih.',
            'id_guru.exists'          => 'Guru pembina yang dipilih tidak valid.',
            'jadwal_latihan.required' => 'Jadwal latihan wajib diisi.',
            'jadwal_latihan.max'      => 'Jadwal latihan maksimal 40 karakter.',
            'gambar.image'            => 'File harus berupa gambar (JPG, PNG).',
            'gambar.max'              => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Masukkan data ke model
        $ekstrakulikuler->nama_ekskul    = $request->nama_ekskul;
        $ekstrakulikuler->id_guru        = $request->id_guru;
        $ekstrakulikuler->jadwal_latihan = $request->jadwal_latihan;
        $ekstrakulikuler->deskripsi      = $request->deskripsi;

        // Upload gambar jika disertakan
        if ($request->hasFile('gambar')) {
            if ($ekstrakulikuler->gambar && Storage::disk('public')->exists($ekstrakulikuler->gambar)) {
                Storage::disk('public')->delete($ekstrakulikuler->gambar);
            }
            $ekstrakulikuler->gambar = $request->file('gambar')->store('ekstrakulikuler', 'public');
        }

        // Simpan ke database
        $ekstrakulikuler->save();

        return redirect()
            ->route('admin.ekstrakulikuler.index')
            ->with(
                'success',
                $id
                    ? 'Data ekstrakulikuler berhasil diperbarui.'
                    : 'Data ekstrakulikuler berhasil disimpan.'
            );
    }

    /**
     * Menampilkan detail informasi ekstrakurikuler.
     */
    public function show($id)
    {
        try {
            $ekstrakurikuler = Ekstrakulikuler::with('guru')->findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ekstrakulikuler.index')
                ->with('error', 'Data ekstrakulikuler tidak ditemukan.');
        }

        return view('admin.ekstrakulikuler.show', compact('ekstrakurikuler'));
    }

    /**
     * Menghapus ekstrakurikuler dan file gambarnya.
     */
    public function destroy($id)
    {
        try {
            $ekstrakulikuler = Ekstrakulikuler::findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ekstrakulikuler.index')
                ->with('error', 'Data ekstrakulikuler tidak ditemukan.');
        }

        if ($ekstrakulikuler->gambar && Storage::disk('public')->exists($ekstrakulikuler->gambar)) {
            Storage::disk('public')->delete($ekstrakulikuler->gambar);
        }

        $ekstrakulikuler->delete();

        return redirect()
            ->route('admin.ekstrakulikuler.index')
            ->with('success', 'Data ekstrakulikuler berhasil dihapus.');
    }
}
