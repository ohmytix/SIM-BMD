@extends('layouts.app')

@section('card')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Informasi User -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="mb-3">Profil Pengguna</h6>

            <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
        </div>
    </div>

    <!-- Ganti Password -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Ubah Password</h6>

            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password"
                           name="current_password"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Password
                </button>
            </form>
        </div>
    </div>

</div>
@endsection