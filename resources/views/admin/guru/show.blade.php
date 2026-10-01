@extends('admin_app')

@section('title', 'Detail Data Guru')

@section('content')
<div style="background-color: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05); margin-bottom: 24px; max-width: 900px; margin-left: auto; margin-right: auto;">

    <!-- HEADER DETAIL -->
    <div style="border-bottom: 1px solid #e9ecef; padding-bottom: 16px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <h4 style="margin: 0; font-weight: bold; color: #344767; font-size: 1.25rem;">
                Detail Data Guru
            </h4>
            <p style="margin: 4px 0 0 0; color: #8392ab; font-size: 0.875rem;">
                Informasi lengkap profil guru SMK YPC Tasikmalaya.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.guru.index') }}"
               style="background-color: #8392ab; color: #ffffff; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.875rem; display: inline-block;">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- PROFILE HERO / CARD HEAD -->
    <div style="background: linear-gradient(310deg, #7928ca, #370b6d); border-radius: 12px; padding: 24px; color: #ffffff; text-align: center; margin-bottom: 24px; box-shadow: 0 4px 15px rgba(121, 40, 202, 0.2);">
        @if($guru->foto && file_exists(public_path('storage/' . $guru->foto)))
            <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_guru }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto 12px auto; border: 3px solid rgba(255, 255, 255, 0.4); display: block;">
        @else
            <div style="width: 70px; height: 70px; background-color: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 1.75rem; font-weight: bold; text-transform: uppercase;">
                {{ substr($guru->nama_guru, 0, 1) }}
            </div>
        @endif
        <h3 style="margin: 0; font-size: 1.5rem; font-weight: bold; color: #ffffff;">{{ $guru->nama_guru }}</h3>
        <p style="margin: 4px 0 0 0; opacity: 0.85; font-size: 0.9rem;">NIP: {{ $guru->nip ?? '-' }}</p>
    </div>

    <!-- TABEL DETAIL DATA -->
    <div style="border: 1px solid #e9ecef; border-radius: 12px; overflow: hidden; margin-bottom: 24px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
            <tbody>
                <tr style="border-bottom: 1px solid #e9ecef; background-color: #f8f9fa;">
                    <th style="padding: 14px 20px; width: 35%; color: #344767; font-weight: 600;">NIP</th>
                    <td style="padding: 14px 20px; color: #495057; font-weight: bold;">{{ $guru->nip ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <th style="padding: 14px 20px; color: #344767; font-weight: 600;">Nama Lengkap</th>
                    <td style="padding: 14px 20px; color: #495057;">{{ $guru->nama_guru }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e9ecef; background-color: #f8f9fa;">
                    <th style="padding: 14px 20px; color: #344767; font-weight: 600;">Mata Pelajaran</th>
                    <td style="padding: 14px 20px; color: #495057; font-weight: bold;">{{ $guru->mapel }}</td>
                </tr>
                <tr>
                    <th style="padding: 14px 20px; color: #344767; font-weight: 600;">Tanggal Terdaftar</th>
                    <td style="padding: 14px 20px; color: #495057;">
                        {{ $guru->created_at ? $guru->created_at->format('d F Y, H:i') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ACTION BUTTONS -->
    <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #e9ecef; padding-top: 20px;">
        <a href="{{ route('admin.guru.index') }}"
           style="background-color: #8392ab; color: #ffffff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.875rem;">
            Kembali
        </a>
        <a href="{{ route('admin.guru.addEdit', Crypt::encrypt($guru->id)) }}"
           style="background: linear-gradient(310deg, #7928ca, #370b6d); color: #ffffff; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.875rem; box-shadow: 0 4px 6px rgba(50,50,93,.11);">
            Edit Data Guru
        </a>
    </div>

</div>
@endsection
