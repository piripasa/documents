<?php

namespace App\Criteria\Users;

use Prettus\Repository\Contracts\RepositoryInterface;
use App\Criteria\AbstractCriteria;

class DocumentByUserIdCriteria extends AbstractCriteria {

    protected $userId;

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $userId = app('request')->get('userId');
        if( $userId > 0 ) {
            $model = $model->where("user_id", "=", $userId);
        }

        return $model;
    }
}
