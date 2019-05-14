<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Article extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'articles';
    protected $dates = ['deleted_at'];
    protected $fillable = ['title','menu_id','slug','description','date'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
