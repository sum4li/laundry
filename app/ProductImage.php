<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class ProductImage extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'product_images';
    protected $dates = ['deleted_at'];
    protected $fillable = ['product_id','image'];
    public $incrementing = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
