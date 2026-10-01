@extends('layouts.kpra')

@section('title', 'Kelola Akses Role')
@section('page-title', 'Kelola Akses Role')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kelola Akses Role</li>
@endsection

@push('styles')
<style>
    .access-card {
        background: #FFFFFF;
        border: 1px solid #E7EBE9;
        border-radius: 16px;
        overflow: hidden;
    }
    .access-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #E7EBE9;
        background: #F7F8F7;
    }
    .module-row {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #F7F8F7;
    }
    .module-row:last-child { border-bottom: 0; }
    .module-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: #087F5B;
        font-size: 0.9rem;
    }
    .permission-label {
        font-size: 0.75rem;
        color: #7A858F;
        margin-right: 0.8rem;
    }
    .form-check-input:checked {
        background-color: #087F5B;
        border-color: #087F5B;
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
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <p class="text-muted mb-0" style="font-size:0.85rem;">
            Atur modul dan hak akses yang dimiliki setiap operator. Admin utama selalu memiliki akses penuh.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm" style="font-size:0.85rem; border-radius:10px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm" style="font-size:0.85rem; border-radius:10px;">
            <i class="fa-solid fa-circle-exclamation me-2"></i>Periksa kembali data akses yang dipilih.
        </div>
    @endif

    <div class="row g-4">
        @foreach ($roles as $role)
            @php($assignedModules = $role->modules->keyBy('id'))
            <div class="col-12 col-xl-6">
                <form method="POST" action="{{ route('admin.access.update', $role) }}" class="access-card h-100 role-access-form">
                    @csrf
                    @method('PUT')

                    <div class="access-card-header d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1 fw-700" style="font-size:0.95rem; color:#0f172a;">{{ $role->label }}</h6>
                            <span class="text-muted" style="font-size:0.72rem;">{{ $role->name }}</span>
                        </div>
                        <span class="save-status text-muted" style="font-size:0.72rem;"></span>
                    </div>

                    @foreach ($modules as $module)
                        @php($access = $assignedModules->get($module->id))
                        <div class="module-row">
                            <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="module-icon"><i class="{{ $module->icon ?? 'fa-solid fa-cube' }}"></i></div>
                                    <div>
                                        <div class="fw-600" style="font-size:0.84rem; color:#0f172a;">{{ $module->label }}</div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $module->key }}</div>
                                    </div>
                                </div>

                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input module-toggle" type="checkbox"
                                           id="role-{{ $role->id }}-module-{{ $module->id }}"
                                           name="modules[{{ $module->id }}][id]" value="{{ $module->id }}"
                                           @checked($access)>
                                    <label class="form-check-label" style="font-size:0.75rem;" for="role-{{ $role->id }}-module-{{ $module->id }}">Akses</label>
                                </div>
                            </div>

                            <div class="permissions mt-2 ps-5" @if(!$access) style="opacity:0.45;" @endif>
                                <label class="permission-label">
                                    <input type="checkbox" class="form-check-input me-1" name="modules[{{ $module->id }}][can_create]" value="1" @checked($access?->pivot?->can_create)>
                                    Tambah
                                </label>
                                <label class="permission-label">
                                    <input type="checkbox" class="form-check-input me-1" name="modules[{{ $module->id }}][can_edit]" value="1" @checked($access?->pivot?->can_edit)>
                                    Ubah
                                </label>
                                <label class="permission-label">
                                    <input type="checkbox" class="form-check-input me-1" name="modules[{{ $module->id }}][can_delete]" value="1" @checked($access?->pivot?->can_delete)>
                                    Hapus
                                </label>
                            </div>
                        </div>
                    @endforeach
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    function syncModuleState(toggle) {
        const row = toggle.closest('.module-row');
        const permissions = row.querySelector('.permissions');

        permissions.style.opacity = toggle.checked ? '1' : '0.45';
        permissions.querySelectorAll('input[type="checkbox"]').forEach(function (input) {
            input.disabled = !toggle.checked;
        });
    }

    document.querySelectorAll('.module-toggle').forEach(function (toggle) {
        syncModuleState(toggle);
        toggle.addEventListener('change', function () {
            syncModuleState(toggle);
        });
    });

    async function autoSaveRoleAccess(form) {
        const status = form.querySelector('.save-status');
        
        status.textContent = 'Menyimpan...';
        status.className = 'save-status text-muted';

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
                throw new Error(data.message || 'Akses gagal disimpan.');
            }

            status.textContent = '✓ Tersimpan';
            status.className = 'save-status text-success';
            setTimeout(() => { status.textContent = ''; }, 2000);
        } catch (error) {
            status.textContent = '✗ ' + error.message;
            status.className = 'save-status text-danger';
        }
    }

    document.querySelectorAll('.role-access-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
        });

        form.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                autoSaveRoleAccess(form);
            });
        });
    });
</script>
@endpush
