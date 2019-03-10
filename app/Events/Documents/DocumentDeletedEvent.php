<?php

namespace App\Events\Documents;

use Prettus\Repository\Events\RepositoryEventBase;

class DocumentDeletedEvent extends RepositoryEventBase
{
    protected $action ="deleted";
 }
