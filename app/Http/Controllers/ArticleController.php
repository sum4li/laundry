<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\ArticleImage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->article = new Article();
        $this->image = new ArticleImage();
    }

    public function index($menu_id)
    {
        return view('backend.article.index',compact('menu_id'));
        // echo "<img src=".asset("storage/upload/sampah_2.jpeg").">";
    }

    public function source($menu_id){
        $query= Article::query();
        $query->where('menu_id',$menu_id);
        return DataTables::eloquent($query)
        ->filter(function ($query) {
            if (request()->has('search')) {
                $query->where(function ($q) {
                    $q->where('title', 'LIKE', '%' . request('search')['value'] . '%');
                });
            }
            })
            ->addColumn('title', function ($data) {
                return str_limit($data->title,50);
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->date)->format('d-m-Y');
            })
            ->addColumn('description', function ($data) {
                return str_limit(strip_tags($data->description,50));
            })
            ->addIndexColumn()
            ->addColumn('action', 'backend.article.index-action')
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create($menu_id)
    {
        return view('backend.article.create',compact(['menu_id']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=> str_slug($request->title),'menu_id'=>$request->menu_id]);
            $article = $this->article->create($request->all());
            foreach($request->image as $row){
                $fileName = Str::uuid();
                $file = $row->storeAs(
                    'public/image/article',$fileName.'.'.$row->extension()
                );
                $this->image->create([
                    'article_id'=>$article->id,
                    'image'=>'storage/image/article/'.$fileName.'.'.$row->extension()
                ]);
            }
            DB::commit();
            return redirect()->route('article.index',$request->menu_id)->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function show($id)
    {
        $data = $this->article->find($id);
        return $data;

    }

    public function edit($id,$menu_id)
    {
        $data = $this->article->find($id);
        return view('backend.article.edit',compact(['data','menu_id']));

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request = $request->merge(['slug'=>str_slug($request->title)]);
            if($request->has('image')){
                foreach($request->image as $row){
                    $fileName = Str::uuid();
                    $file = $row->storeAs(
                        'public/image/article',$fileName.'.'.$row->extension()
                    );
                    $this->image->create([
                        'article_id'=>$id,
                        'image'=>'storage/image/article/'.$fileName.'.'.$row->extension()
                    ]);
                }
            }
            $this->article->find($id)->update($request->all());
            DB::commit();
            return redirect()->route('article.index',$request->menu_id)->with('success-message','Data telah dirubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }


    }

    public function destroy($id)
    {
        $this->article->destroy($id);
        return redirect()->back()->with('success-message','Data telah dihapus');

    }

    public function getImage($id){
       return $this->image->where('article_id',$id)->get();

    }

    public function destroyImage($id){
        $this->image->destroy($id);
    }

}
