<form method="post" action="{{ route('password.update') }}" class="mt-4">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">Kata Sandi Sekarang</label>
        <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
               autocomplete="current-password" placeholder="••••••••">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">Kata Sandi Baru</label>
        <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
               autocomplete="new-password" placeholder="••••••••">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
               autocomplete="new-password" placeholder="••••••••">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex gap-2 align-items-center">
        <button type="submit" class="btn btn-save">
            <i class="fa-solid fa-save me-1"></i>Ubah Kata Sandi
        </button>

        @if (session('status') === 'password-updated')
            <span class="text-success" style="font-size:0.85rem;">
                <i class="fa-solid fa-check me-1"></i>Kata sandi berhasil diubah
            </span>
        @endif
    </div>
</form>
