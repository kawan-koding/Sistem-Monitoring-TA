@php
    $profil_logo = \App\Models\Setting::where('options', 'profile')->where('label', 'logo')->first();
@endphp
@include('layout.admin-header') <!-- Menyertakan file header.blade.php -->
@include('layout.admin-topbar') <!-- Menyertakan file header.blade.php -->
@include('layout.admin-sidebar') <!-- Menyertakan file header.blade.php -->

@yield('content')

@include('layout.admin-footer') <!-- Menyertakan file footer.blade.php -->
