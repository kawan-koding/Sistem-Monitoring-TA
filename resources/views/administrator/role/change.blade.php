@extends('administrator.layout.main')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('apps.roles.change-permissions', $role->id) }}" method="post">
            @csrf
            <div class="mb-3">
                <div class="row col-md-12">
                    @foreach($permissions as $key => $permission)
                        <div class="col-md-3 col-sm-6" style="margin-bottom: 40px">
                            @foreach($permission as $keyItem => $item)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="permission-{{ $key }}{{ $keyItem }}"  name="permission[]" value="{{ $item->name }}" {{ $item->is_checked ? 'checked' : ''}} />
                                    <label for="permission-{{ $key }}{{ $keyItem }}" class="form-check-label">{{ $item->display_name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('apps.roles') }}" class="btn btn-secondary waves-effect mx-1">Kembali</a>
            <button class="btn btn-primary waves-effect mx-1" type="submit" data-form-loading>Simpan</button>
        </form>
    </div>
</div>

@endsection