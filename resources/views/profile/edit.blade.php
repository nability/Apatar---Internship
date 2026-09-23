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
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .profile-card h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .profile-card p.text-muted {
        font-size: 0.8rem;
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
    .form-control:focus {
        border-color: var(--kpra-green);
        box-shadow: 0 0 0 0.2rem rgba(16,185,129,0.15);
    }
    .btn-save {
        background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-size: 0.85rem;
    }
    .btn-save:hover {
        opacity: 0.9;
        color: #fff;
    }
    .btn-danger {
        background: #ef4444;
        border: none;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-size: 0.85rem;
    }
    .alert {
        border-radius: 10px;
        font-size: 0.85rem;
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
                    <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--kpra-green),var(--kpra-cyan));display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:2rem;color:#fff;font-weight:700;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-2" style="font-size:0.85rem;">{{ Auth::user()->email }}</p>
                <span class="badge bg-success bg-opacity-15 text-success px-3 py-2" style="font-size:0.75rem;border-radius:8px;">
                    <i class="fa-solid fa-circle-check me-1"></i>Aktif
                </span>
            </div>

            {{-- Quick Info --}}
            <div class="profile-card">
                <h6 class="fw-700 mb-3" style="font-size:0.85rem;">Info Cepat</h6>
                <div class="d-flex justify-content-between mb-2" style="font-size:0.8rem;">
                    <span class="text-muted">Bergabung</span>
                    <span class="fw-600">{{ Auth::user()->created_at->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between" style="font-size:0.8rem;">
                    <span class="text-muted">Role</span>
                    <span class="fw-600">Admin KPRA</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
