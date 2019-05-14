<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\GalleryImage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    public function __construct()
    {
        $this->gallery = new Gallery();
        $this->image = new GalleryImage();
    }

    public function index($menu_id)
    {
        return view('backend.gallery.index',compact('menu_id'));
        // echo "<img src=".asset("storage/upload/sampah_2.jpeg").">";
    }

    public function source($menu_id){
        $query= Gallery::query();
        $query->where('menu_id',$menu_id);
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('image', function ($data) {
                $image = $this->image->where('gallery_id',$data->id)->get()->first()->image;
                return "<img src='".asset($image)."' width='50px' height='50px'>";
            })
            ->addColumn('name', function ($data) {
                return str_limit($data->name,50);
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.gallery.index-action')
            ->rawColumns(['action','image'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.gallery.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=> str_slug($request->name),'menu_id'=>$request->menu_id]);
            $gallery = $this->gallery->create($request->all());
            foreach($request->image as $row){
                $fileName = Str::uuid();
                $file = $row->storeAs(
                    'public/image/gallery',$fileName.'.'.$row->extension()
                );
                $this->image->create([
                    'gallery_id'=>$gallery->id,
                    'image'=>'storage/image/gallery/'.$fileName.'.'.$row->extension()
                ]);
            }
            DB::commit();
            return redirect()->route('gallery.index',$request->menu_id)->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function show($id)
    {
        $data = $this->gallery->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->gallery->find($id);
        return view('backend.gallery.edit',compact(['data','menu_id']));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->title)]);
            if($request->has('image')){
                foreach($request->image as $row){
                    $fileName = Str::uuid();
                    $file = $row->storeAs(
                        'public/image/gallery',$fileName.'.'.$row->extension()
                    );
                    $this->image->create([
                        'gallery_id'=>$id,
                        'image'=>'storage/image/gallery/'.$fileName.'.'.$row->extension()
                    ]);
                }
            }
            $this->gallery->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('gallery.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function destroy($id)
    {
        $this->gallery->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

    public function getImage($id){
       return $this->image->where('gallery_id',$id)->get();

    }

    public function destroyImage($id){
        $this->image->destroy($id);
    }

}
