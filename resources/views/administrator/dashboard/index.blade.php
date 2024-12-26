@extends('administrator.layout.main')

@section('content')
    @if (session('switchRoles') == 'Admin')
        @include('administrator.dashboard.partials.admin')
    @endif
@endsection
