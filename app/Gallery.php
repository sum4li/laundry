<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Gallery extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'galleries';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','menu_id'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

}
