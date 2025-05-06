@extends('administrator.layout.main')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="text-center">
            <h4>Buku Panduan</h4>
            <p class="text-muted">Baca atau <a href="{{ asset('storage/images/settings/'. $guide->value) }}" download="{{ $guide->value }}"
                target="_blank" class="text-primary"><i class="bx bx-download"></i> Download </a> Petunjuk penggunaan aplikasi {{ getSetting('app_name') }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <iframe src="{{ asset('storage/images/settings/'. $guide->value) }}" width="100%" height="800px"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
