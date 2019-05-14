<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\ProductImage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->product = new Product();
        $this->image = new ProductImage();
    }

    public function index($menu_id)
    {
        return view('backend.product.index',compact(['menu_id']));
    }

    public function source($menu_id){
        $query= Product::query();
        $query->where('menu_id',$menu_id);
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('name', function ($data) {
                return str_limit($data->name,50);
            })
            ->addColumn('description', function ($data) {
                return str_limit(strip_tags($data->description,50));
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.product.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.product.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=> str_slug($request->name)]);
            $product = $this->product->create($request->all());
            foreach($request->image as $row){
                $fileName = Str::uuid();
                $file = $row->storeAs(
                    'public/image/product',$fileName.'.'.$row->extension()
                );
                $this->image->create([
                    'product_id'=>$product->id,
                    'image'=>'storage/image/product/'.$fileName.'.'.$row->extension()
                ]);
            }
            DB::commit();
            return redirect()->route('product.index',$request->menu_id)->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }



    }

    public function show($id)
    {
        $data = $this->product->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->product->find($id);
        return view('backend.product.edit',compact(['data','menu_id']));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->name)]);
            if($request->has('image')){
                foreach($request->image as $row){
                    $fileName = Str::uuid();
                    $file = $row->storeAs(
                        'public/image/product',$fileName.'.'.$row->extension()
                    );
                    $this->image->create([
                        'product_id'=>$id,
                        'image'=>'storage/image/product/'.$fileName.'.'.$row->extension()
                    ]);
                }
            }
            $this->product->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('product.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->product->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

    public function getImage($id){
        return $this->image->where('product_id',$id)->get();
    }

    public function destroyImage($id){
        $this->image->destroy($id);
    }

}
