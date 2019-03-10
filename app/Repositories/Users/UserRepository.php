<?php

namespace App\Repositories\Users;

use App\Entities\Users\User;
use App\Criteria\EloquentCriteria;
use App\Repositories\AbstractRepository;
use App\Criteria\Users\DocumentByUserIdCriteria;
use App\Criteria\Users\UserByTypeCriteria;

/**
 * Class DocumentRepository.
 *
 * @package namespace App\Repositories\Documents;
 */
class UserRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(DocumentByUserIdCriteria::class));
        $this->pushCriteria(app(EloquentCriteria::class));
    }

    public function presenter()
    {
        return "App\\Presenters\\Users\\UserPresenter";
    }

    public function validator()
    {
        return "App\\Validators\\Users\\UserValidator";
    }
}
