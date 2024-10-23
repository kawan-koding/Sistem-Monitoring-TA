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
        <p class="mb-3"><strong>Judul : </strong>{{ $data->judul}}</p>   
       <form id="approveForm" method="POST" action="">
            @csrf
            <table class="table table-centered mb-0">
                <tbody>
                    @forelse ($data->ambilTawaran as $item)
                    <tr>
                        <td>
                            <div class="row">
                               <div class="col-md-8 ">
                                    <h5 class="font-size-14 text-dark m-0">{{ $item->mahasiswa->nama_mhs }}</h5>
                                </div>
                                <div class="col-md-4 text-end  d-none d-sm-block">
                                    @if($item->status == 'Menunggu')
                                        <a href="#" data-toggle="approve-mhs" data-url="{{ route('apps.rekomendasi-topik.accept', $item->id) }}" class="badge rounded-pill bg-success font-size-11">Setujui</a>
                                        <a href="#" data-toggle="reject-mhs" data-url="{{ route('apps.rekomendasi-topik.reject', $item->id) }}" class="badge rounded-pill bg-danger font-size-11">Tolak</a>
                                    @elseif($item->status == 'Disetujui')
                                        <a href="#" onclick="hapusMahasiswaTerkait('{{ $item->id }}', '{{ route('apps.program-studi.delete', $item->id) }}')" class="badge rounded-pill bg-warning font-size-11">Hapus</a>
                                    @endif
                                </div>
                            </div>
                            <p class="m-0" style="text-align: justify">{{ $item->description }}</p>
                            <a href="{{ asset('storage/files/apply-topik/' . $item->file )}}" target="_blank" class="nav-link text-primary mt-1"><span>Lihat Cv/Portofolio</span></a>
                            <div class="d-sm-none">
                                @if($item->status == 'Menunggu')
                                    <a href="#" data-toggle="approve-mhs" data-url="{{ route('apps.rekomendasi-topik.accept', $item->id) }}" class="badge rounded-pill bg-success font-size-11">Setujui</a>
                                    <a href="#" data-toggle="reject-mhs" data-url="{{ route('apps.rekomendasi-topik.reject', $item->id) }}" class="badge rounded-pill bg-danger font-size-11">Tolak</a>
                                @elseif($item->status == 'Disetujui')
                                    <a href="#" onclick="hapusMahasiswaTerkait('{{ $item->id }}', '{{ route('apps.program-studi.delete', $item->id) }}')" class="badge rounded-pill bg-warning font-size-11">Hapus</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center">
                            <h5 class="font-size-14 text-dark m-0">Belum ada mahasiswa yang ambil</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>
</div>

@endsection