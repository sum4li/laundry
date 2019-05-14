<?php

namespace App\Http\Controllers;

use App\Socmed;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SocmedController extends Controller
{

    public function __construct()
    {
        $this->socmed = new Socmed();
    }

    public function index()
    {
        return view('backend.socmed.index');
    }

    public function source(){
        $query= Socmed::query();
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%')
                    ->orWhere('url', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('name', function ($data) {
                return ucwords($data->name);
            })
            ->addColumn('url', function ($data) {
                return $data->url;
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.socmed.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('backend.socmed.create');
    }

    public function store(Request $request)
    {
        if($this->socmed->where('name',$request->name)->get()->count() > 0){
            return redirect()->route('socmed.index')->with('error-message','Gagal Menyimpan. Data '.$request->name.' sudah ada, edit data yang ada');
        }else{
            $this->socmed->create($request->all());
            return redirect()->route('socmed.index')->with('success-message','Data telah disimpan');
        }
    }

    public function show($id)
    {
        $data = $this->socmed->find($id);
        return $data;

    }

    public function edit($id)
    {
        $data = $this->socmed->find($id);
        return view('backend.socmed.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        $name = $this->socmed->find($id)->name;
        if($this->socmed->where('name',$request->name)->get()->count() > 0){
            if($request->name == $name){
                $this->socmed->find($id)->update($request->all());
                return redirect()->route('socmed.index')->with('success-message','Data telah d irubah');
            }else{
                return redirect()->route('socmed.index')->with('error-message','Gagal Meruba h. Data '.$request->name.' sudah ada,   edit data yang ada');
            }
        }else{
            $this->socmed->find($id)->update($request->all());
            return redirect()->route('socmed.index')->with('success-message','Data telah d irubah');
        }
    }

    public function destroy($id)
    {
         $this->socmed->destroy($id);
         return redirect()->route('socmed.index')->with('success-message','Data telah dihapus');

    }

}
