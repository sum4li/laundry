<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Slideshow extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'slideshows';
    protected $dates = ['deleted_at'];
    protected $fillable = ['images','title','description','url'];
    public $incrementing = false;

}
