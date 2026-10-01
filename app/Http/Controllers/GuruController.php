<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::latest()->get();
        return view('admin.guru.index', compact('guru'));
    }

    public function addEdit($id = null)
    {
        $guru = null;

        if ($id) {
            try {
                $id = Crypt::decrypt($id);
                $guru = Guru::findOrFail($id);
            } catch (\Exception $e) {
                return redirect()->route('admin.guru.index')->with('error', 'Data guru tidak ditemukan.');
            }
        }

        return view('admin.guru.form', compact('guru'));
    }

    public function save(Request $request, $id = null)
    {
        $decryptedId = null;

        if ($id) {
            try {
                $decryptedId = Crypt::decrypt($id);
                $guru = Guru::findOrFail($decryptedId);
            } catch (\Exception $e) {
                return redirect()->route('admin.guru.index')->with('error', 'Data guru tidak ditemukan.');
            }
        } else {
            $guru = new Guru();
        }

        $request->validate([
            'nama_guru' => ['required', 'string', 'max:100'],
            'nip'       => ['nullable', 'string', 'max:30', Rule::unique('guru', 'nip')->ignore($decryptedId)],
            'mapel'     => ['required', 'string', 'max:100'],
            'foto'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'nip.unique'         => 'NIP sudah terdaftar pada guru lain.',
            'mapel.required'     => 'Mata pelajaran wajib diisi.',
            'foto.image'         => 'File harus berupa gambar.',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        // Upload Foto jika ada
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $guru->foto = $request->file('foto')->store('guru', 'public');
        }

        $guru->nama_guru = $request->nama_guru;
        $guru->nip       = $request->nip;
        $guru->mapel     = $request->mapel;
        $guru->save();

        return redirect()->route('admin.guru.index')->with(
            'success',
            $decryptedId ? 'Data guru berhasil diperbarui.' : 'Data guru berhasil disimpan.'
        );
    }

    public function show($id)
    {
        try {
            $guru = Guru::findOrFail(Crypt::decrypt($id));
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')->with('error', 'Data guru tidak ditemukan.');
        }

        return view('admin.guru.show', compact('guru'));
    }

    public function destroy($id)
    {
        try {
            $guru = Guru::findOrFail(Crypt::decrypt($id));
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')->with('error', 'Data guru tidak ditemukan.');
        }

        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
