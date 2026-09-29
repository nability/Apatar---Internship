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
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }
    .access-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .module-row {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .module-row:last-child { border-bottom: 0; }
    .module-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
    }
    .permission-label {
        font-size: 0.72rem;
        color: #64748b;
        margin-right: 0.8rem;
    }
    .form-check-input:checked {
        background-color: var(--kpra-green);
        border-color: var(--kpra-green);
    }
    .btn-save {
        background: linear-gradient(135deg, var(--kpra-green), var(--kpra-cyan));
        border: 0;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 8px;
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
                        <button type="submit" class="btn btn-save px-3 py-2 save-access-button">
                            <i class="fa-solid fa-save me-1"></i>Simpan
                        </button>
                        <span class="save-status text-muted" style="display:none;font-size:0.72rem;"></span>
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

    document.querySelectorAll('.role-access-form').forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const button = form.querySelector('.save-access-button');
            const status = form.querySelector('.save-status');
            const originalLabel = button.innerHTML;

            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Menyimpan...';
            status.style.display = 'none';

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

                status.textContent = data.message;
                status.className = 'save-status text-success';
            } catch (error) {
                status.textContent = error.message;
                status.className = 'save-status text-danger';
            } finally {
                status.style.display = 'inline-block';
                button.disabled = false;
                button.innerHTML = originalLabel;
            }
        });
    });
</script>
@endpush
