<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Service extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'services';
    protected $dates = ['deleted_at'];
    protected $fillable = ['menu_id','icon','name','description'];
    public $incrementing = false;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
