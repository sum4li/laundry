<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Pages extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'pages';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','menu_id','slug','description'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

}
