<?php

namespace App\Entities\Users;

use App\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User.
 *
 * @package namespace App\Entities\Documents;
 */
class User extends BaseModel
{
    use SoftDeletes;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "email",
        "password"
    ];

    protected $hidden = [
        'remember_token',
        'deleted_at',
    ];

    public function setPasswordAttribute($password)
    {
        if (app('hash')->needsRehash($password)) {
            $password = app('hash')->make($password);
        }

        $this->attributes['password'] = $password;
    }

    public function documents()
    {
        return $this->hasMany('App\Entities\Documents\Document');
    }

}
