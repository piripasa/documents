<?php

namespace App\Listeners\Documents;

use Prettus\Repository\Events\RepositoryEventBase;
use App\Utilities\FileUtility;

class DocumentDeletedListener
{
    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase  $event
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {
        FileUtility::deleteFile($event->getModel()->file, 'documents');
        FileUtility::deleteFile($event->getModel()->image, 'documents');

    }
}
