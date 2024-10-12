@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Profil Admin</h1>
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Biodata Pribadi</h5>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> Admin</p>
            <p><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $user->phone ?? 'Tidak tersedia' }}</p>
        </div>
    </div>
</div>
@endsection
