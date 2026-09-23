<div>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        <i class="fa-solid fa-trash me-1"></i>Hapus Akun
    </button>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-700" style="color:#991b1b;">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Hapus Akun?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3" style="font-size:0.9rem; color:#1e293b;">
                        Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <p class="mb-0" style="font-size:0.85rem; color:#64748b;">
                        Masukkan kata sandi Anda untuk mengonfirmasi penghapusan.
                    </p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}" class="needs-validation" novalidate>
                    @csrf
                    @method('delete')

                    <div class="modal-body border-top pt-3">
                        <label for="password_delete" class="form-label">Kata Sandi</label>
                        <input id="password_delete" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                               required placeholder="••••••••">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer border-top-0 gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash me-1"></i>Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
