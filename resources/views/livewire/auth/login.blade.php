<div class="card bg-white shadow-sm rounded login-card">
    <div class="card-body p-4">

        <!-- Logo / Judul -->
        <div class="text-center mb-4">
            <div class="fw-bold" style="font-size: 20px;">PMD</div>
            <div class="login-subtitle">Sistem Pengelolaan Data</div>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="login">
            <div class="mb-3">
                <label class="form-label small">Email</label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       wire:model.defer="email"
                       placeholder="Masukkan email">

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small">Password</label>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       wire:model.defer="password"
                       placeholder="Masukkan password">

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-login">
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Login
            </button>
        </form>

    </div>
</div>
