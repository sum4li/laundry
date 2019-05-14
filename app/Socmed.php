<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Socmed extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'socmeds';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','url'];
    public $incrementing = false;

}
