<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Menu;
use App\Pages;
use App\MenuType;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->menuType = new MenuType();
        $this->menu = new Menu();
        $this->pages = new Pages();
    }

    public function index()
    {
        return view('backend.menu.index');
    }

    public function source(){
        $query= Menu::query();
        $query->orderBy('order','asc');
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('name', function ($data) {
                return title_case($data->name);
            })
            ->addColumn('type', function ($data) {
                return title_case($data->menu_type->name);
            })
            ->addColumn('parent', function ($data) {
                return $data->parent_id == NULL ? '-':$data->parent->name;
            })
            ->addIndexColumn()
            ->addColumn('order', function ($data) use ($query){
                if($query->count() > 1){
                    if($query->min('order') == $data->order){
                        $disabledUp = 'disabled';
                        $disabledDown = '';
                    }elseif($query->max('order') == $data->order){
                        $disabledUp = '';
                        $disabledDown = 'disabled';
                    }else{
                        $disabledUp = '';
                        $disabledDown = '';
                    }
                }else{
                    $disabledUp = 'disabled';
                    $disabledDown = 'disabled';
                }

                // return $disabledUp.'+'.$disabledDown;

                return '<a href="'.route('menu.orderUp',$data->id).'"
                class="btn btn-danger btn-sm '.$disabledUp.'"
                data-toggle="tooltip"
                data-placement="top"
                title="Up">
                <i class="fa fa-chevron-up"></i>
                </a>

                <a href="'.route('menu.orderDown',$data->id).'"
                class="btn btn-info btn-sm '.$disabledDown.'"
                data-toggle="tooltip"
                title="Down">
                <i class="fa fa-chevron-down"></i>
                </a>';
            })
            ->addColumn('action', 'backend.menu.index-action')
            ->rawColumns(['action','order'])
            ->toJson();
    }

    public function create()
    {
        return view('backend.menu.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = $this->menu->where('parent_id',NULL)->get()->count()+1;
            $request = $request->merge(['slug'=> str_slug($request->name),'order'=>$order]);
            $menu = $this->menu->create($request->all());

            if($this->menuType->find($request->menu_type_id)->slug == 'pages'){
                $this->pages->create([
                    'menu_id' => $menu->id,
                    'name' => $menu->name,
                    'slug' => $menu->slug,
                    'description' => $request->name
                ]);
            }

            DB::commit();
            return redirect()->route('menu.index')->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }

    }

    public function show($id)
    {
        $data = $this->menu->find($id);
        return $data;

    }

    public function edit($id)
    {
        $data = $this->menu->find($id);
        return view('backend.menu.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $this->menu->find($id);
            $request = $request->merge(['slug'=>str_slug($request->name)]);


            if($data->menu_type_id == 'pages'){
                $this->pages->where('menu_id',$id)->update([
                    'slug' => str_slug($request->slug),
                    'name' => $request->name,
                    'description' => $request->name
                ]);
            }else{
                $this->pages->where('menu_id',$id)->delete();
                if($this->menuType->find($request->menu_type_id)->slug == 'pages'){
                    $this->pages->create([
                        'menu_id' => $id,
                        'slug' => $data->slug,
                        'name' => $data->name,
                        'description' => $request->name
                    ]);
                }
            }

            $data->update($request->all());
            DB::commit();
            return redirect()->route('menu.index')->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function destroy($id)
    {
         $this->menu->destroy($id);
         return redirect()->route('menu.index')->with('success-message','Data telah dihapus');
    }

    public function orderUp($id){
        DB::beginTransaction();
        try {
            $data = $this->menu->find($id);
            $new_order = $data->order-1;
            $old_data = $this->menu->where('order',$new_order)->update(['order'=>$data->order]);
            $new_data = $data->update(['order'=>$new_order]);

            DB::commit();
            return redirect()->back()->with('success-message','Data berhasil dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function orderDown($id){
        DB::beginTransaction();
        try {
            $data = $this->menu->find($id);
            $new_order = $data->order+1;
            $old_data = $this->menu->where('order',$new_order)->update(['order'=>$data->order]);
            $new_data = $data->update(['order'=>$new_order]);
            DB::commit();
            return redirect()->back()->with('success-message','Data berhasil dirubah');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

}
