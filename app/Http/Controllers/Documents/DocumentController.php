<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\MutationController;
use App\Repositories\Documents\DocumentRepository;

class DocumentController extends MutationController
{
    public function __construct(DocumentRepository $repository){
        parent::__construct($repository);
    }
}
