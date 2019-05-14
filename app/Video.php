<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Video extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'videos';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','menu_id','slug','url'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

}
