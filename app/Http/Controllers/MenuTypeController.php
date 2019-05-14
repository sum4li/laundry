<?php

namespace App\Http\Controllers;

use App\MenuType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MenuTypeController extends Controller
{

    public function __construct()
    {
        $this->menuType = new MenuType();
    }

    public function index()
    {
        return view('backend.menuType.index');
    }

    public function source(){
        $query= MenuType::query();
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
            ->addColumn('route', function ($data) {
                return $data->route;
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.menuType.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('backend.menuType.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug'=> str_slug($request->name)
        ]);
        $this->menuType->create($request->all());
        return redirect()->route('menuType.index')->with('success-message','Data telah disimpan');

    }

    public function show($id)
    {
        $data = $this->menuType->find($id);
        return $data;

    }

    public function edit($id)
    {
        $data = $this->menuType->find($id);
        return view('backend.menuType.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request = $request->merge(['slug'=>str_slug($request->name)]);
        $this->menuType->find($id)->update($request->all());
        return redirect()->route('menuType.index')->with('success-message','Data telah dirubah');
    }

    public function destroy($id)
    {
         $this->menuType->destroy($id);
         return redirect()->route('menuType.index')->with('success-message','Data telah dihapus');

    }

}
