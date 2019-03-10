<?php
namespace App\Rules;

class ConfirmPasswordRule implements RuleInterface {

    public function validate($attribute, $value, $parameters, $validator): bool
    {
        $password = app('request')->get('password');
        if($password === $value) {
            return true;
        }

        return false;
    }
}
