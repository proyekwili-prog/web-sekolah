@extends('admin_app')

@section('title', 'Kelola Data Guru')

@section('content')
<div style="background-color: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05); margin-bottom: 24px;">

    <!-- HEADER & TOMBOL TAMBAH -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h4 style="margin: 0; font-weight: bold; color: #344767; font-size: 1.25rem;">
                Daftar Data Guru
            </h4>
            <p style="margin: 4px 0 0 0; color: #8392ab; font-size: 0.875rem;">
                Kelola informasi pengajar dan staf guru SMK YPC Tasikmalaya.
            </p>
        </div>
        <a href="{{ route('admin.guru.addEdit') }}"
           style="background: linear-gradient(310deg, #7928ca, #370b6d); color: #ffffff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.875rem; box-shadow: 0 4px 6px rgba(50,50,93,.11);">
            + Tambah Guru Baru
        </a>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if (session('success'))
        <div style="background-color: #d1e7dd; border: 1px solid #badbcc; color: #0f5132; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #f8d7da; border: 1px solid #f5c2c7; color: #842029; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.875rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABEL DATA GURU -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
            <thead>
                <tr style="border-bottom: 2px solid #e9ecef; background-color: #f8f9fa; color: #8392ab;">
                    <th style="padding: 14px 16px; font-weight: 700; width: 50px; text-align: center;">NO</th>
                    <th style="padding: 14px 16px; font-weight: 700; text-align: center; width: 80px;">FOTO</th>
                    <th style="padding: 14px 16px; font-weight: 700;">NAMA GURU</th>
                    <th style="padding: 14px 16px; font-weight: 700;">NIP</th>
                    <th style="padding: 14px 16px; font-weight: 700;">MATA PELAJARAN</th>
                    <th style="padding: 14px 16px; font-weight: 700; text-align: center;">L/P</th>
                    <th style="padding: 14px 16px; font-weight: 700;">NO. HP</th>
                    <th style="padding: 14px 16px; font-weight: 700; text-align: center; width: 180px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guru as $index => $item)
                    <tr style="border-bottom: 1px solid #e9ecef;">
                        <!-- NO -->
                        <td style="padding: 16px; text-align: center; color: #344767; font-weight: 600; vertical-align: middle;">
                            {{ $index + 1 }}
                        </td>

                        <!-- KOLOM FOTO -->
                        <td style="padding: 16px; text-align: center; vertical-align: middle;">
                            @if($item->foto && file_exists(public_path('storage/' . $item->foto)))
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_guru }}"
                                     style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 1px solid #d2d6da; display: inline-block;">
                            @else
                                <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #f3e8ff; color: #7928ca; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.875rem; margin: 0 auto;">
                                    {{ strtoupper(substr($item->nama_guru, 0, 1)) }}
                                </div>
                            @endif
                        </td>

                        <!-- NAMA GURU -->
                        <td style="padding: 16px; vertical-align: middle; color: #344767; font-weight: 600;">
                            {{ $item->nama_guru }}
                        </td>

                        <!-- NIP -->
                        <td style="padding: 16px; color: #495057; font-weight: 500; vertical-align: middle;">
                            {{ $item->nip ?? '-' }}
                        </td>

                        <!-- MAPEL -->
                        <td style="padding: 16px; vertical-align: middle;">
                            <span style="background-color: #f3e8ff; color: #6b21a8; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; display: inline-block;">
                                {{ $item->mapel }}
                            </span>
                        </td>

                        <!-- JENIS KELAMIN -->
                        <td style="padding: 16px; text-align: center; vertical-align: middle;">
                            @if($item->jenis_kelamin == 'L')
                                <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">
                                    Laki-laki
                                </span>
                            @elseif($item->jenis_kelamin == 'P')
                                <span style="background-color: #fce7f3; color: #be185d; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">
                                    Perempuan
                                </span>
                            @else
                                <span style="color: #8392ab;">-</span>
                            @endif
                        </td>

                        <!-- NO HP -->
                        <td style="padding: 16px; color: #495057; font-weight: 500; vertical-align: middle;">
                            {{ $item->no_hp ?? '-' }}
                        </td>

                        <!-- AKSI -->
                        <td style="padding: 16px; text-align: center; vertical-align: middle;">
                            <div style="display: flex; justify-content: center; align-items: center; gap: 6px;">
                                <!-- DETAIL -->
                                <a href="{{ route('admin.guru.show', Crypt::encrypt($item->id)) }}"
                                   style="background-color: #17c1e8; color: #ffffff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.75rem; font-weight: bold;">
                                    Detail
                                </a>

                                <!-- EDIT -->
                                <a href="{{ route('admin.guru.addEdit', Crypt::encrypt($item->id)) }}"
                                   style="background-color: #cb0c9f; color: #ffffff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.75rem; font-weight: bold;">
                                    Edit
                                </a>

                                <!-- HAPUS -->
                                <form action="{{ route('admin.guru.destroy', Crypt::encrypt($item->id)) }}" method="POST" style="margin: 0; display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #ea0606; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: bold; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <!-- colspan disesuaikan menjadi 8 karena ada tambahan 1 kolom foto -->
                        <td colspan="8" style="text-align: center; padding: 32px; color: #8392ab;">
                            Belum ada data guru terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
