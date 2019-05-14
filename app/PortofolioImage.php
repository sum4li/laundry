<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class PortofolioImage extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'portofolio_images';
    protected $dates = ['deleted_at'];
    protected $fillable = ['portofolio_id','image'];
    public $incrementing = false;

    public function portofolio()
    {
        return $this->belongsTo('App\Portofolio');
    }
}
