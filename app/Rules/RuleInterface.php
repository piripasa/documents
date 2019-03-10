<?php
namespace App\Rules;


interface RuleInterface{
    public function validate($attribute, $value, $parameters, $validator) : bool;
}
