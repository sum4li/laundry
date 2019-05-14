<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class ArticleImage extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'article_images';
    protected $dates = ['deleted_at'];
    protected $fillable = ['article_id','image'];
    public $incrementing = false;

    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
