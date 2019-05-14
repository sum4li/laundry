<?php

namespace App\Http\Controllers;

use App\Slideshow;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class SlideshowController extends Controller
{

    public function __construct()
    {
        $this->slideshow = new Slideshow();
    }

    public function index()
    {
        return view('backend.slideshow.index');
    }

    public function source(){
        $query= Slideshow::query();
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('title', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('title', function ($data) {
                return str_limit($data->title,50);
            })
            ->addColumn('image', function ($data) {
                return "<img src='".asset($data->images)."' width='50px' height='50px'>";
            })
            ->addColumn('url', function ($data) {
                return str_limit(strip_tags($data->url,50));
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.slideshow.index-action')
            ->rawColumns(['action','image'])
            ->toJson();
    }

    public function create()
    {
        return view('backend.slideshow.create');
    }

    public function store(Request $request)
    {
        $fileName = Str::uuid();
        $file = $request->image->storeAs(
            'public/image/slideshow',$fileName.'.'.$request->image->extension()
        );
        $request->merge([
            'images'=>'storage/image/slideshow/'.$fileName.'.'.$request->image->extension(),
            'slug'=> str_slug($request->title)
        ]);

        $this->slideshow->create($request->all());

        return redirect()->route('slideshow.index')->with('success-message','Data telah disimpan');

    }

    public function show($id)
    {
        $data = $this->slideshow->find($id);
        return $data;

    }

    public function edit($id)
    {
        $data = $this->slideshow->find($id);
        return view('backend.slideshow.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $this->slideshow->find($id);
            if($request->has('image')){
                $images = str_replace('storage','',$data->images);
                Storage::delete('public'.$images);
                $fileName = Str::uuid();
                $file = $request->image->storeAs(
                    'public/image/slideshow',$fileName.'.'.$request->image->extension()
                );
                $request = $request->merge([
                    'slug'=> str_slug($request->name),
                    'images'=>'storage/image/slideshow/'.$fileName.'.'.$request->image->extension()
                ]);
            }else{
                $request = $request->merge(['slug'=>str_slug($request->name)]);

            }
            $this->slideshow->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('slideshow.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function destroy($id)
    {
         $this->slideshow->destroy($id);
         return redirect()->route('slideshow.index')->with('success-message','Data telah dihapus');

    }

}
