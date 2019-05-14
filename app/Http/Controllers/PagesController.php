<?php

namespace App\Http\Controllers;

use App\Pages;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class PagesController extends Controller
{

    public function __construct()
    {
        $this->pages = new Pages();
    }

    public function index($menu_id)
    {
        $data = $this->pages->where('menu_id',$menu_id)->get()->first();
        return view('backend.pages.index',compact(['data','menu_id']));
    }

    public function update(Request $request, $menu_id)
    {
        $id = $this->pages->where('menu_id',$menu_id)->get()->first()->id;
        $this->pages->find($id)->update($request->all());
        return redirect()->route('pages.index',$menu_id)->with('success-message','Data telah dirubah');
    }

    public function slugUpdate(Request $request, $slug)
    {
        $id = $this->pages->where('slug',$slug)->get()->first()->id;
        $request = $request->merge(['slug'=>$slug]);
        $this->pages->find($id)->update($request->all());
        return redirect()->route('pages.slug',$slug)->with('success-message','Data telah dirubah');
    }

}
