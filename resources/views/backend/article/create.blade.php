@extends('backend.layouts')
@section('title','Tambah Data')
@section('content')
<div class="col-lg-12">
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <form action="{{route('article.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                          <label>Gambar</label>
                          <input type="file" name="image[]" class="" id="fileinput" required="" multiple>
                        </div>
                        <div class="form-group">
                          <label>Judul</label>
                          <input type="text" name="title" id="" class="form-control border-dark-50" required="">
                          <input type="hidden" name="menu_id" value="{{$menu_id}}" class="form-control border-dark-50" required="">
                        </div>
                        <div class="form-group">
                          <label>Tanggal</label>
                          <input type="text" name="date" id="" class="form-control border-dark-50 datepicker" required="">
                        </div>
                        <div class="form-group">
                          <label>Content</label>
                            <textarea name="description" id="ckeditor" class="form-control border-dark-50" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-light" href="{{route('article.index',$menu_id)}}">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $('.datepicker').datepicker({
        format : 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight:true
    });

    CKEDITOR.replace('ckeditor');

    $('#fileinput').fileinput({
        uploadUrl:'#',
          browseClass: "btn btn-primary btn-block",
          fileActionSettings:{
            showZoom:false,
            showUpload:false,
            removeClass: "btn btn-danger",
            removeIcon: "<i class='fa fa-trash'></i>"
          },
          showCaption: false,
          showRemove: false,
          showUpload: false,
          showCancel: false,
          dropZoneEnabled: false,
          allowedFileExtensions: ['jpg', 'png','jpeg'],
    });
</script>

@endpush
