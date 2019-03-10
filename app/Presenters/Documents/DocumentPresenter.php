<?php
namespace App\Presenters\Documents;

use Prettus\Repository\Presenter\FractalPresenter;
use App\Transformers\Documents\DocumentTransformer;

class DocumentPresenter extends FractalPresenter {

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DocumentTransformer();
    }
}
?>