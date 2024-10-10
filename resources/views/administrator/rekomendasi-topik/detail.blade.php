@extends('administrator.layout.main')

@section('content')

@if(session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
       <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
       </button>
   </div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
   <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
   </button>
</div>
@endif
<div class="card">
    <div class="card-body">
        <p><strong>Judul : {{ $data->judul}}</strong></p>
        <hr>
       <form id="approveForm" method="POST" action="">
            @csrf
            @forelse ($data->ambilTawaran as $item)
                <div class="faq-box d-flex align-items-start mb-4">
                    @if($item->status == 'Menunggu')
                    <div class="faq-icon me-3">
                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="approve-checkbox">
                    </div>
                    @else 
                    <div class="me-3">
                        <button type="button" data-toggle="delete-mhs" data-url="{{ route('apps.hapus-mahasiswa-yang-terkait', $item->id)}}" class="btn btn-sm" title="Hapus"><i class="fas fa-trash-alt text-danger"></i></button>
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
                        <p class="text-muted m-0">{{ $item->description }}</p>
                        <a href="{{ asset('storage/files/apply-topik/' . $item->file )}}" target="_blank" class="nav-link text-primary mt-1"><span>Lihat Cv/Portofolio</span></a>
                    </div>
                </div>
            @empty
                <div class="text-center">
                    <p class="text-muted">Tidak ada data</p>
                </div>
            @endforelse

            <div class="text-end">
                <a href="{{ route('apps.rekomendasi-topik') }}" class="btn btn-light">Kembali</a>
                @if($data->ambilTawaran->count() > 0)
                <button  data-url="{{ route('apps.tolak-mahasiswa-yang-terkait', $data->id) }}" data-toggle="reject-mhs" class="btn btn-danger">Tolak</button>
                <button  data-url="{{ route('apps.rekomendasi-topik.accept', $data->id) }}" data-toggle="approve-mhs" class="btn btn-primary">Setujui</button>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection