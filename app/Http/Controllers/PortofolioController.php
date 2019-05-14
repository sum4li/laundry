<?php

namespace App\Http\Controllers;

use App\Portofolio;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\PortofolioImage;
use Illuminate\Support\Str;

class PortofolioController extends Controller
{

    public function __construct()
    {
        $this->portofolio = new Portofolio();
        $this->image = new PortofolioImage();
    }

    public function index($menu_id)
    {
        return view('backend.portofolio.index',compact(['menu_id']));
    }

    public function source($menu_id){
        $query= Portofolio::query();
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
            ->addColumn('action', 'backend.portofolio.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.portofolio.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=> str_slug($request->name)]);
            $portofolio = $this->portofolio->create($request->all());
            foreach($request->image as $row){
                $fileName = Str::uuid();
                $file = $row->storeAs(
                    'public/image/portofolio',$fileName.'.'.$row->extension()
                );
                $this->image->create([
                    'portofolio_id'=>$portofolio->id,
                    'image'=>'storage/image/portofolio/'.$fileName.'.'.$row->extension()
                ]);
            }
            DB::commit();
            return redirect()->route('portofolio.index',$request->menu_id)->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }



    }

    public function show($id)
    {
        $data = $this->portofolio->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->portofolio->find($id);
        return view('backend.portofolio.edit',compact(['data','menu_id']));

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
                        'public/image/portofolio',$fileName.'.'.$row->extension()
                    );
                    $this->image->create([
                        'portofolio_id'=>$id,
                        'image'=>'storage/image/portofolio/'.$fileName.'.'.$row->extension()
                    ]);
                }
            }
            $this->portofolio->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('portofolio.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->portofolio->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

    public function getImage($id){
        return $this->image->where('portofolio_id',$id)->get();
    }

    public function destroyImage($id){
        $this->image->destroy($id);
    }

}
