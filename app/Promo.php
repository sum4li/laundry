<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Promo extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'promos';
    protected $dates = ['deleted_at'];
    protected $fillable = ['menu_id','name','slug','images','description'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
