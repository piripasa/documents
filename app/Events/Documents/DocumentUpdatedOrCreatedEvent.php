<?php

namespace App\Events\Documents;

use Prettus\Repository\Events\RepositoryEventBase;

class DocumentUpdatedOrCreatedEvent extends RepositoryEventBase
{
    protected $action ="updatedOrCreated";
 }
