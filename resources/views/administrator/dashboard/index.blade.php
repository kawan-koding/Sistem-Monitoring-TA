@extends('administrator.layout.main')

@section('content')
    @if (session('switchRoles') == 'Admin')
        @include('administrator.dashboard.partials.admin')
    @elseif (session('switchRoles') == 'Mahasiswa')
        @include('administrator.dashboard.partials.mahasiswa')
    @endif
@endsection
