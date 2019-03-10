<?php
namespace App\Transformers\Documents;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Entities\Documents\Document;
use App\Utilities\FileUtility;

class DocumentTransformer extends TransformerAbstract
{
    public function transform(Document $document)
    {
        $result = $document->toArrayCamel();

        if(isset($result['image'])) {
            $result['image'] = FileUtility::fileUrl($result['image'], 'documents');
        }

        if(isset($result['file'])) {
            $result['file'] = FileUtility::fileUrl($result['file'], 'documents');
        }

        return $result;
    }
}
