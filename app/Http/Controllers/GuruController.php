<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    // =========================
    // TAMPIL DATA GURU
    public function index()
    {
        $guru = Guru::latest()->get();

        return view('admin.guru.index', compact('guru'));
    }

    public function addEdit($id = null)
    {
        try {
            $guru = $id
                ? Guru::findOrFail(Crypt::decrypt($id))
                : null;
        } catch (\Exception $e) {
            return redirect()
               ->route('admin.guru.index')
               ->with('error', 'Data guru tidak ditemukan.');
        }
        return view('admin.guru_form', compact('guru'));
    }

    public function save(Request $request, $id = null)
    {
        if ($id) {
            try {
                $id = Crypt::decrypt($id);
                $guru = Guru::findOrfail($id);
            } catch (\Exception $e) {
                return redirect()
                   ->route('admin.guru.index')
                   ->with('error', 'Data guru tidak ditemukan.');
            }
        } else {
            $guru = new Guru();
        }

        $request->validate([
            'nama_guru' => 'required|string|max:40',
            'mapel' => 'required|string|max:40',
            'nip'       => 'nullable|unique:guru,nip,' . ($id ?? 'NULL') . ',id',
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_guru.required'  => 'Nama guru wajib diisi.',
            'mapel.required'  => 'Mata pelajaran wajib diisi.',
            'nip.unique'  => 'NIP sudah terdaftar pada guru lain.',
            'foto.image'  => 'Foto harus berupa file gambar (JPG, PNG.',
            'foto.max'  => 'Ukuran foto maksimal 2mb.',
        ]);

        $guru->nama_guru = $request->nama_guru;
        $guru->nip = $request->nip;
        $guru->mapel = $request->mapel;

        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)){
                Storage::disk('public')->delete($guru->foto);
            }
            $guru->foto = $request->file('foto')->store('guru', 'public');
        }
        $guru->save();

        return redirect()
            ->route('admin.guru.index')
            ->with(
                'success',
                $id
                  ? 'Data guru berhasil diperbarui.'
                  : 'Data guru berhasil disimpan.'
            );
    }

    public function show($id)
    {
        try {
            $guru = Guru::with('ekstrakulikuler')->findOrFail(Crypt::decrypt($id));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        return view('admin.guru.show', compact('guru'));
    }

    public function destroy($id)
    {
        try {
             $guru = Guru::findOrFail(Crypt::decrypt($id));
        } catch (\Exception $e) {
            return redirect()
               ->route('admin.guru.index')
               ->with('error', 'Data guru tidak ditemukan.');
        }

        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
