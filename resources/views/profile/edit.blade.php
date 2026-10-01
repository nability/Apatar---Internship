@extends('layouts.kpra')

@section('title', 'Profil')
@section('page-title', 'Pengaturan Profil')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@push('styles')
<style>
    .profile-card {
        background: #FFFFFF;
        border: 1px solid #E7EBE9;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    .profile-card h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #1F2933;
        margin-bottom: 0.5rem;
    }
    .profile-card p.text-muted {
        font-size: 0.85rem;
        color: #7A858F;
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1F2933;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #E7EBE9;
        padding: 0.65rem 1rem;
        font-size: 0.875rem;
        background: #FFFFFF;
    }
    .form-control:focus {
        border-color: #087F5B;
        box-shadow: 0 0 0 3px rgba(8, 127, 91, 0.10);
        outline: none;
    }
    .btn-save {
        background: #087F5B;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85rem;
    }
    .btn-save:hover {
        background: #056B4D;
        color: #fff;
    }
    .btn-danger {
        background: #D9534F;
        border: none;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85rem;
    }
    .alert {
        border-radius: 10px;
        font-size: 0.85rem;
        border: 1px solid #E7EBE9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">

            {{-- Update Profile Information --}}
            <div class="profile-card">
                <h5><i class="fa-solid fa-user me-2" style="color:var(--kpra-green);"></i>Informasi Profil</h5>
                <p class="text-muted">Perbarui informasi akun dan alamat email Anda.</p>

                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="profile-card">
                <h5><i class="fa-solid fa-lock me-2" style="color:var(--kpra-cyan);"></i>Ubah Kata Sandi</h5>
                <p class="text-muted">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan.</p>

                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div class="profile-card" style="border-color: #fca5a5;">
                <h5 style="color:#991b1b;"><i class="fa-solid fa-triangle-exclamation me-2"></i>Hapus Akun</h5>
                <p class="text-muted">Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>

                @include('profile.partials.delete-user-form')
            </div>

        </div>

        <div class="col-lg-4">
            {{-- User Info Card --}}
            <div class="profile-card text-center">
                <div class="mb-3">
                    <div style="width:80px;height:80px;border-radius:50%;background:#087F5B;display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:2rem;color:#fff;font-weight:700;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-2" style="font-size:0.85rem;">{{ Auth::user()->email }}</p>
                <span class="badge px-3 py-2" style="background:#E7F5EF; color:#087F5B; border:1px solid #E7EBE9; font-size:0.75rem; border-radius:999px;">
                    <i class="fa-solid fa-circle-check me-1"></i>Aktif
                </span>
            </div>

            {{-- Quick Info --}}
            <div class="profile-card">
                <h6 class="fw-700 mb-3" style="font-size:0.9rem; color:#1F2933;">Info Cepat</h6>
                <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                    <span class="text-muted">Bergabung</span>
                    <span class="fw-600" style="color:#1F2933;">{{ Auth::user()->created_at->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between" style="font-size:0.85rem;">
                    <span class="text-muted">Role</span>
                    <span class="fw-600" style="color:#1F2933;">Admin KPRA</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
