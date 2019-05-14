<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->user = new User();
    }

    public function index($menu_id)
    {
        return view('backend.user.index',compact(['menu_id']));
    }

    public function source($menu_id){
        $query= User::query();
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
            ->addColumn('action', 'backend.user.index-action')
            ->rawColumns(['action','image'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.user.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->name)]);
            $user = $this->user->create($request->all());
            DB::commit();
            return redirect()->route('user.index')->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function show($id)
    {
        $data = $this->user->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->user->find($id);
        return view('backend.user.edit',compact(['data','menu_id']));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->name)]);
            $this->user->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('user.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->user->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

    public function change(){
        return view('backend.user.change');
    }

    public function updatePassword(Request $request){
        // $credentials = ['password'=>]
        // if(Auth::attempt){

        // }
        if (Hash::check($request->old_password, Auth::user()->password)) {
            if($request->new_password != $request->confirm_password){
                return redirect()->back()->with("error-message","Maaf konfirmasi password salah");
            }else{
                $user = Auth::user();
                $user->password = bcrypt($request->new_password);
                $user->save();
                return redirect()->back()->with("success-message","Password Berhasil Diganti");
            }
        }else{
            return redirect()->back()->with("error-message","Maaf password salah");
        }
    }

}
