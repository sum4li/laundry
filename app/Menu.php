<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Menu extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'menus';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','is_submenu','slug','parent_id','menu_type_id','order'];
    public $incrementing = false;

    public function parent()
    {
        return $this->belongsTo('App\Menu');
    }

    public function menu_type()
    {
        return $this->belongsTo('App\MenuType');
    }
}
