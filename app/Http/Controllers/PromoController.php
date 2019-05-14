<?php

namespace App\Http\Controllers;

use App\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromoController extends Controller
{

    public function __construct()
    {
        $this->promo = new Promo();
    }

    public function index($menu_id)
    {
        return view('backend.promo.index',compact('menu_id'));
    }

    public function source($menu_id){
        $query= Promo::query();
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
                return "<img src='".asset($data->images)."' width='50px' height='50px'>";
            })
            ->addColumn('name', function ($data) {
                return str_limit($data->name,50);
            })
            ->addColumn('description', function ($data) {
                return str_limit(strip_tags($data->description,50));
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.promo.index-action')
            ->rawColumns(['action','image'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.promo.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = Str::uuid();
            $file = $request->image->storeAs(
                'public/image/promo',$fileName.'.'.$request->image->extension()
            );
            $request = $request->merge([
                'slug'=> str_slug($request->name),
                'menu_id'=>$request->menu_id,
                'images'=>'storage/image/promo/'.$fileName.'.'.$request->image->extension()
            ]);
            $promo = $this->promo->create($request->all());
            DB::commit();
            return redirect()->route('promo.index',$request->menu_id)->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function show($id)
    {
        $data = $this->promo->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->promo->find($id);
        return view('backend.promo.edit',compact(['data','menu_id']));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $this->promo->find($id);
            if($request->has('image')){
                $images = str_replace('storage','',$data->images);
                Storage::delete('public'.$images);
                $fileName = Str::uuid();
                $file = $request->image->storeAs(
                    'public/image/promo',$fileName.'.'.$request->image->extension()
                );
                $request = $request->merge([
                    'slug'=> str_slug($request->name),
                    'images'=>'storage/image/promo/'.$fileName.'.'.$request->image->extension()
                ]);
            }else{
                $request = $request->merge(['slug'=>str_slug($request->name)]);

            }
            $this->promo->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('promo.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function destroy($id)
    {
        $data = $this->promo->find($id);
        $images = str_replace('storage','',$data->images);
        Storage::delete('public'.$images);
        $this->data->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

    public function getImage($id){
        return $this->promo->find($id);
    }



}
