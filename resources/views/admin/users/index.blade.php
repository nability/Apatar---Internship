@extends('layouts.kpra')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@push('styles')
<style>
    .user-panel {
        background: #FFFFFF;
        border: 1px solid #E7EBE9;
        border-radius: 16px;
        overflow: hidden;
    }
    .user-panel-header {
        padding: 1rem 1.25rem;
        background: #F7F8F7;
        border-bottom: 1px solid #E7EBE9;
    }
    .user-row {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #F7F8F7;
    }
    .user-row:last-child { border-bottom: 0; }
    .user-avatar {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        background: #087F5B;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .btn-save {
        background: #087F5B;
        border: 0;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.5rem 1rem;
    }
    .btn-save:hover { color: #fff; opacity: 0.9; }
    .form-control, .form-select { font-size: 0.85rem; border-radius: 10px; border: 1px solid #E7EBE9; }
    .form-control:focus, .form-select:focus { border-color: #087F5B; box-shadow: 0 0 0 3px rgba(8, 127, 91, 0.10); }
    .role-check { font-size: 0.78rem; color: #7A858F; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm" style="font-size:0.85rem;border-radius:10px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm" style="font-size:0.85rem;border-radius:10px;">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="user-panel">
                <div class="user-panel-header">
                    <h6 class="mb-1 fw-700" style="font-size:0.95rem;">Tambah User</h6>
                    <p class="mb-0 text-muted" style="font-size:0.75rem;">Akun dibuat oleh admin dan dapat langsung diberi role.</p>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}" class="p-3 create-user-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-size:0.8rem;font-weight:600;">Nama</label>
                        <input id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-size:0.8rem;font-weight:600;">Email</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" style="font-size:0.8rem;font-weight:600;">Password</label>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label" style="font-size:0.8rem;font-weight:600;">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-label" style="font-size:0.8rem;font-weight:600;">Role Awal</div>
                        @foreach ($roles as $role)
                            <label class="d-block role-check mb-2">
                                <input type="checkbox" class="form-check-input me-1" name="roles[]" value="{{ $role->id }}">
                                {{ $role->label }}
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-save w-100 py-2">
                        <i class="fa-solid fa-user-plus me-1"></i>Buat User
                    </button>
                    <div class="create-user-status mt-2" style="display:none;font-size:0.78rem;"></div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="user-panel">
                <div class="user-panel-header d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-700" style="font-size:0.95rem;">Daftar User</h6>
                        <p class="mb-0 text-muted" style="font-size:0.75rem;">Atur satu atau beberapa role untuk setiap user.</p>
                    </div>
                    <span class="badge bg-light text-dark">{{ $users->count() }} user</span>
                </div>

                @foreach ($users as $user)
                    <div class="user-row">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="fw-600" style="font-size:0.85rem;color:#0f172a;">{{ $user->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $user->email }}</div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('admin.users.roles.update', $user) }}" class="d-flex align-items-center gap-3 flex-wrap user-role-form">
                                @csrf
                                @method('PUT')
                                @foreach ($roles as $role)
                                    <label class="role-check">
                                        <input type="checkbox" class="form-check-input me-1" name="roles[]" value="{{ $role->id }}"
                                            @checked($user->roles->contains('id', $role->id))>
                                        {{ $role->label }}
                                    </label>
                                @endforeach
                                <span class="role-save-status" style="display:none;font-size:0.72rem;"></span>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function autoSaveUserRoles(form) {
        const status = form.querySelector('.role-save-status');
        
        status.textContent = 'Menyimpan...';
        status.className = 'role-save-status text-muted';
        status.style.display = 'block';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                },
                body: new FormData(form),
            });
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || data.errors?.roles?.[0] || 'Perubahan gagal disimpan.');
            }

            status.textContent = '✓ Tersimpan';
            status.className = 'role-save-status text-success';
            setTimeout(() => { status.style.display = 'none'; }, 2000);
        } catch (error) {
            status.textContent = '✗ ' + error.message;
            status.className = 'role-save-status text-danger';
        }
    }

    document.querySelectorAll('.user-role-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
        });

        form.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                autoSaveUserRoles(form);
            });
        });
    });
</script>
@endpush
