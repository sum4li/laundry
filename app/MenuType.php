<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class MenuType extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'menu_types';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','slug','route'];
    public $incrementing = false;
}
