<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Criteria\AbstractCriteria;
use App\Criteria\AbstractESCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;


/**
 * Interface AbstractRepository.
 *
 * @package namespace App\Repositories\Documents;
 */
abstract class AbstractRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * Apply criteria in current Query
     *
     * @return $this
     */
    protected function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        $criteria = $this->getCriteria();

        if ($criteria) {
            foreach ($criteria as $c) {
                if ( $c instanceof RequestCriteria || $c instanceof AbstractCriteria ) {
                    $this->model = $c->apply($this->model, $this);
                }
            }
        }

        return $this;
    }

    /**
     * @param id - id to be deleted
     * Varify the item can be deleted or not
     */
    public function verifyDelete($id){
        return $this;
    }

    public function validate($attributes)
    {
        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            if( $this->versionCompare($this->app->version(), "5.2.*", ">") ){
                $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
            }else{
                $model = $this->model->newInstance()->forceFill($attributes);
                $model->addVisible($this->model->getHidden());
                $attributes = $model->toArray();
            }

            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }
    }
}
