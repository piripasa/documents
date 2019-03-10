<?php

namespace App\Entities\Documents;

use App\Entities\BaseModel;
use App\Utilities\FileUtility;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Document.
 *
 * @package namespace App\Entities\Documents;
 */
class Document extends BaseModel implements Transformable
{
    use SoftDeletes, TransformableTrait;
    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "name",
        "image",
        "file",
    ];

    protected $hidden = ['deleted_at'];

    public function transform()
    {
        $result = [];
        if (isset($this->image)){
            $result['image'] = url(FileUtility::fileUrl($this->image, 'documents'));
        }

        if(isset($this->file)) {
            $result['file'] = url(FileUtility::fileUrl($this->file, 'documents'));
        }

        return array_merge($this->toArrayCamel(), $result);
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\Users\User');
    }
}
