<?php
namespace App\Rules;


class RuleValidator{

    protected $rules = [
        'confirm_password' => ConfirmPasswordRule::class,
        'combine_unique' => CombineUniqueRule::class,
    ];

    public function getRules()
    {
        return $this->rules;
    }

}
