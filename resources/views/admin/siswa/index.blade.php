@extends('admin_app')

@section('title', 'Kelola Siswa')

@section('content')
<div style="background-color: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05); margin-bottom: 24px;">

    <!-- HEADER: JUDUL & TOMBOL TAMBAH -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <h4 style="margin: 0; font-weight: bold; color: #344767; font-size: 1.25rem;">
            Daftar Siswa Sekolah
        </h4>

        <!-- TOMBOL TAMBAH SISWA -->
        <a href="{{ route('admin.siswa.addEdit') }}"
           style="background: linear-gradient(310deg, #7928ca, #370b6d); color: #ffffff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.875rem; display: inline-flex; align-items: center; box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08); transition: all 0.2s ease;">
            + Tambah Siswa
        </a>
    </div>

    <!-- TABEL DATA SISWA -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem; color: #67748e;">
            <thead>
                <tr style="border-bottom: 1px solid #e9ecef; background-color: #f8f9fa;">
                    <th style="padding: 12px 16px; text-align: center; width: 50px;">No</th>
                    <th style="padding: 12px 16px;">NISN</th>
                    <th style="padding: 12px 16px;">Nama Siswa</th>
                    <th style="padding: 12px 16px; text-align: center;">Jenis Kelamin</th>
                    <th style="padding: 12px 16px; text-align: center;">Tahun Masuk</th>
                    <th style="padding: 12px 16px; text-align: center; width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $item)
                    <tr style="border-bottom: 1px solid #e9ecef;">
                        <td style="padding: 12px 16px; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="padding: 12px 16px;">
                            <span style="background-color: #f1f3f5; padding: 4px 8px; border-radius: 4px; font-family: monospace;">
                                {{ $item->nisn }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; font-weight: 600; color: #344767;">{{ $item->nama_siswa }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            @if ($item->jenis_kelamin == 'Laki-Laki')
                                <span style="background-color: #e7f5ff; color: #1c7ed6; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold;">
                                    Laki-Laki
                                </span>
                            @else
                                <span style="background-color: #fff0f6; color: #d6336c; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold;">
                                    Perempuan
                                </span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px; text-align: center;">{{ $item->tahun_masuk }}</td>
                        <td style="padding: 12px 16px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <a href="{{ route('admin.siswa.show', ['id' => Crypt::encrypt($item->id)]) }}"
                                   style="background-color: #17a2b8; color: white; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 0.75rem; font-weight: bold;">
                                    Detail
                                </a>
                                <a href="{{ route('admin.siswa.addEdit', ['id' => Crypt::encrypt($item->id)]) }}"
                                   style="background-color: #ffc107; color: #212529; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 0.75rem; font-weight: bold;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.siswa.delete', ['id' => Crypt::encrypt($item->id)]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 24px; text-align: center; color: #8392ab;">
                            Belum ada data siswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
