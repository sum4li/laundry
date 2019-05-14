<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class VideoController extends Controller
{

    public function __construct()
    {
        $this->video = new Video();
    }

    public function index($menu_id)
    {
        return view('backend.video.index',compact(['menu_id']));
    }

    public function source($menu_id){
        $query= Video::query();
        $query->where('menu_id',$menu_id);
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('url', function ($data) {
                return str_limit($data->url,50);

            })
            ->addColumn('name', function ($data) {
                return str_limit($data->name,50);
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.video.index-action')
            ->rawColumns(['action','image'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.video.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->name)]);
            $video = $this->video->create($request->all());
            DB::commit();
            return redirect()->route('video.index')->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function show($id)
    {
        $data = $this->video->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->video->find($id);
        return view('backend.video.edit',compact(['data','menu_id']));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->name)]);
            $this->video->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('video.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->video->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

}
