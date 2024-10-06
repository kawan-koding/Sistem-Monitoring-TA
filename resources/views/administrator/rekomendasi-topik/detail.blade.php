@extends('administrator.layout.main')

@section('content')

<div class="card">
    <div class="card-body">
        <p><strong>Judul : {{ $data->judul}}</strong></p>
        <hr>
       <form id="approveForm" method="POST" action="{{ route('apps.rekomendasi-topik.accept', $data->id) }}">
            @csrf
            @foreach ($data->ambilTawaran as $item)
                <div class="faq-box d-flex align-items-start mb-4">
                    @if($item->status == 'Menunggu')
                    <div class="faq-icon me-3">
                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="approve-checkbox">
                    </div>
                    @endif
                    <div class="flex-1">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <h5 class="font-size-15">{{ $item->mahasiswa->nama_mhs }}</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 d-flex justify-content-start justify-content-sm-end">
                                <p class="small">{{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('D MMMM Y') }}</p>
                            </div>
                        </div>
                        <p class="text-muted">{{ $item->description }}</p>
                    </div>
                </div>
            @endforeach
            <div class="text-end">
                <a href="{{ route('apps.rekomendasi-topik') }}" class="btn btn-light">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection