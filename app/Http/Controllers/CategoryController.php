<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        return view('backend.category.index');
    }

    public function source(){
        $query= Category::query();
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('name', function ($data) {
                return ucwords($data->name);
            })
            ->addColumn('description', function ($data) {
                return $data->description;
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.category.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->name)]);
            $this->category->create($request->all());
            DB::commit();
            return redirect()->route('category.index')->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }

    }

    public function show($id)
    {
        $data = $this->category->find($id);
        return $data;

    }

    public function edit($id)
    {
        $data = $this->category->find($id);
        return view('backend.category.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        $name = $this->category->find($id)->name;
        if($this->category->where('name',$request->name)->get()->count() > 0){
            if($request->name == $name){
                $this->category->find($id)->update($request->all());
                return redirect()->route('category.index')->with('success-message','Data telah d irubah');
            }else{
                return redirect()->route('category.index')->with('error-message','Gagal Meruba h. Data '.$request->name.' sudah ada,   edit data yang ada');
            }
        }else{
            $this->category->find($id)->update($request->all());
            return redirect()->route('category.index')->with('success-message','Data telah d irubah');
        }
    }

    public function destroy($id)
    {
         $this->category->destroy($id);
         return redirect()->route('category.index')->with('success-message','Data telah dihapus');

    }

}
