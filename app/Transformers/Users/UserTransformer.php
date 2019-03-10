<?php
namespace App\Transformers\Users;

use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $result = $user->toArrayCamel();

        return $result;
    }
}
