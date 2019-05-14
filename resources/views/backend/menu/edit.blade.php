@extends('backend.layouts')
@section('title','Ubah Data')
@section('content')
<div class="col-lg-12">
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <form action="{{route('menu.update',$data->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                          <label>Nama</label>
                          <input type="text" name="name" value="{{$data->name}}" class="form-control border-dark-50" required="">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="menu_type_id" class="form-control select2" required="">
                                @foreach (App\MenuType::get() as $row)
                                    <option value="{{$row->id}}" {{$data->menu_type_id == $row->id ? 'selected':''}}>{{title_case($row->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Submenu</label>
                            <select name="parent_id" class="form-control select2">
                                <option value="">Pilihi Parent Menu</option>
                                @foreach (App\Menu::get() as $row)
                                    <option value="{{$row->id}}" {{$data->parent_id == $row->id ? 'selected':''}}>{{title_case($row->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-light" href="{{route('menu.index')}}">Batal</a>
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
    $(document).ready(function(){
        $('.select2').select2({
            theme: 'bootstrap'
        });
    })
</script>

@endpush
