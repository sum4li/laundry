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
            <form action="{{route('promo.update',$data->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Gambar Lama</label>
                            <div id="loadImage" class="row"></div>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            {{-- <input type="file" name="image[]" id="lul"> --}}
                            <input type="file" name="image" id="edit-file">
                        </div>
                        <div class="form-group">
                          <label>Nama</label>
                          <input type="text" name="name" value="{{$data->name}}" class="form-control border-dark-50" required="">
                          <input type="hidden" name="menu_id" value="{{$menu_id}}" class="form-control border-dark-50" required="">
                        </div>
                        <div class="form-group">
                          <label>Content</label>
                        <textarea name="description" id="ckeditor" class="form-control border-dark-50" required>{{$data->description}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-gorup">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-light" href="{{route('promo.index',$menu_id)}}">Batal</a>
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
<script>
    // $(document).ready(function(){


    CKEDITOR.replace('ckeditor');

    function loadImage(){
        $.getJSON("{{route('promo.getImage',$data->id)}}", function(data){
            // $.each(data, function(index,value){
                var image = "{!! asset('image') !!}";
                image = image.replace('image',data.images);
                $('#loadImage').append('<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<div class="card bg-dark text-white shadow">'+
                            '<img class="card-img" src="'+image+'" alt="">'+
                        '</div>'+
                    '</div>'+
                '</div>')
            // });
        });
    }

    loadImage();

    $("#edit-file").fileinput({

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
    // })
</script>

@endpush
