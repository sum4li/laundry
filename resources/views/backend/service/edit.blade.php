@extends('backend.layouts')
@section('title','Ubah Data')
@section('content')
<div class="col-lg-12">
    {{-- <div class="card border-left-primary"> --}}
    <div class="card mb-4">
        <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <form action="{{route('service.update',$data->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{$data->name}}" class="form-control border-dark-50" required="">
                                <input type="hidden" name="menu_id" value="{{$menu_id}}" class="form-control border-dark-50" required="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="text" name="icon" id="icon-picker" value="{{$data->icon}}" class="form-control border-dark-50" required="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                              <label>Deskripsi</label>
                                <textarea name="description" class="form-control border-dark-50" required="">{{$data->description}}</textarea>
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-light" href="{{route('service.index',$menu_id)}}">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#icon-picker').iconpicker({
            inputSearch: true
        });
    });
</script>

@endpush
