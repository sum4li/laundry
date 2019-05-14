<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Portofolio extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'portofolios';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','menu_id','slug','description','category_id'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
