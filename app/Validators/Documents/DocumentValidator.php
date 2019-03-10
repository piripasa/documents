<?php

namespace App\Validators\Documents;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DocumentValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [         
            'file' => 'required|mimes:pdf',
        ],
        ValidatorInterface::RULE_UPDATE => [
        ]
    ];
}

