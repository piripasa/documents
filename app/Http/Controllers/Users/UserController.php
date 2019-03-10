<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\MutationController;
use App\Repositories\Users\UserRepository;
use Illuminate\Http\Request;

class UserController extends MutationController
{
    public function __construct(UserRepository $repository){
        parent::__construct($repository);
    }
}
