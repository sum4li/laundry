@extends('backend.layouts')
@section('title','Tambah Sosial Media')
@section('content')
<div class="col-lg-12">
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <form action="{{route('socmed.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                          <label>Nama</label>
                          @php
                            $name = ['facebook','twitter','instagram','youtube'];
                          @endphp
                          <select name="name" class="custom-select">
                              @foreach ($name as $socmed)
                                    <option value="{{$socmed}}">{{title_case($socmed)}}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                          <label>URL</label>
                          <input type="text" name="url" class="form-control border-dark-50" required="">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-light" href="{{route('socmed.index')}}">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
