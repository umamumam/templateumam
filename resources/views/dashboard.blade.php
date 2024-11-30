@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="text-center">
    <h1>Welcome, {{ $user->name }}</h1>
    <p>Your role: {{ $user->role->name }}</p>
    
    <!-- Daftar Menu Berdasarkan Role -->
    <div class="mt-4">
        <h4>Accessible Menus</h4>
        <ul class="list-group">
            @foreach ($menus as $menu)
                <li class="list-group-item">
                    <a href="{{ $menu->link }}" class="btn btn-link">{{ $menu->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('logout') }}" class="btn btn-danger mt-4">Logout</a>
</div>
@endsection
