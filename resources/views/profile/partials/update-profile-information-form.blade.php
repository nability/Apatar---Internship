<form method="post" action="{{ route('profile.update') }}" class="mt-4">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" 
               placeholder="Nama lengkap">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
               value="{{ old('email', $user->email) }}" required autocomplete="username" 
               placeholder="email@example.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="alert alert-warning mb-3" style="font-size:0.85rem;">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>
            Email belum diverifikasi. 
            <form method="post" action="{{ route('verification.send') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-link p-0" style="font-size:0.85rem;">Kirim ulang</button>
            </form>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success mb-3" style="font-size:0.85rem;">
                Email verifikasi telah dikirim.
            </div>
        @endif
    @endif

    <div class="d-flex gap-2 align-items-center">
        <button type="submit" class="btn btn-save">
            <i class="fa-solid fa-save me-1"></i>Simpan
        </button>
        
        @if (session('status') === 'profile-updated')
            <span class="text-success" style="font-size:0.85rem;">
                <i class="fa-solid fa-check me-1"></i>Berhasil disimpan
            </span>
        @endif
    </div>
</form>
