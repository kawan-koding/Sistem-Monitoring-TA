@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span class="d-block d-sm-none"><i class="mdi mdi-check-circle-outline"></i></span>
                        <span class="d-none d-sm-block">Sudah Terbagi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apps.pembagian-dosen.belum-dibagi') }}">
                        <span class="d-block d-sm-none"><i class="mdi mdi-av-timer"></i></span>
                        <span class="d-none d-sm-block">Belum Terbagi</span>
                    </a>
                </li>
            </ul>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Judul</th>
                                <th>Mahasiswa</th>
                                <th>Dosen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="badge bg-soft-primary small mb-1">ACC</span>
                                    <h5 class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. A nihil ipsum natus commodi corporis incidunt ipsam doloremque accusamus reiciendis nam.</h5>
                                    <p class="m-0 text-muted small">TOPIK - JENIS</p>
                                </td>
                                <td>RIKIANSYAH ARIS KURNIAWAN</td>
                                <td>
                                    <strong>Pembimbing</strong>
                                    <ol>
                                        <li>Lorem, ipsum.</li>
                                        <li>Lorem, ipsum dolor.</li>
                                    </ol>
                                    <strong>Penguji</strong>
                                    <ol>
                                        <li>Lorem ipsum dolor sit.</li>
                                        <li>Lorem, ipsum dolor.</li>
                                    </ol>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary mb-3" title="Edit"><i class="bx bx-edit-alt"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>  
</div>

@endsection