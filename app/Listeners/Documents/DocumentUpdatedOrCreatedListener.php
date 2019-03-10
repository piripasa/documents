<?php

namespace App\Listeners\Documents;

use Prettus\Repository\Events\RepositoryEventBase;
use App\Utilities\FileUtility;
use Spatie\PdfToImage\Pdf;

class DocumentUpdatedOrCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase  $event
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {
        $attributes = app('request')->all();
        $model = $event->getModel();
        $data = [];
        $randomVal = time();

        $directory = 'documents';
        $data['user_id'] = app('request')->user->id;
        //app('files')->link(storage_path('app/public'), base_path('public'));
        if( !empty($attributes['file']) ) {
            $documentPdfName = sprintf("document_%d_%s", $model->id, $randomVal);
            $documentOk = FileUtility::uploadFile($attributes['file'], $documentPdfName, $directory, 'local');
            $basePath = storage_path('app/' . $documentOk);
            //dd($basePath);
            //$documentOk = str_replace($directory.'/', '', $documentOk);
            if($documentOk) {
                $data['name'] = $documentPdfName;
                $pdf = new Pdf($basePath);
                $path = str_replace('.pdf', '.jpg', $basePath);
                $pdf->saveImage($path);
                FileUtility::uploadFile($basePath, $documentPdfName.'.pdf', $directory, 'public');
                FileUtility::uploadFile($pdf->getImageData($path), $documentPdfName.'.jpg', $directory, 'public');

                unlink($basePath);
                unlink($path);

                $data['file'] = $documentPdfName.'.pdf';
                $data['image'] = $documentPdfName.'.jpg';
            }
        }


        if( count($data) > 0 ) {
            $model->update($data);
        }
    }
}
