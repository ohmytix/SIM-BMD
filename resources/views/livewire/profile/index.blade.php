@extends('layouts.app')

@section('card')
<div class="card shadow-sm">
    <div class="card-body">
        <h6 class="mb-3">Profil Pengguna</h6>

        <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
    </div>
</div>
@endsection
