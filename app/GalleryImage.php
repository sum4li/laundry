<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class GalleryImage extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'gallery_images';
    protected $dates = ['deleted_at'];
    protected $fillable = ['gallery_id','image'];
    public $incrementing = false;

    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }
}
