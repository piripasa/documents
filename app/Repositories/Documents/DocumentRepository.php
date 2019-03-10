<?php

namespace App\Repositories\Documents;

use App\Criteria\Users\DocumentByUserIdCriteria;
use App\Entities\Documents\Document;
use App\Events\Documents\DocumentDeletedEvent;
use App\Events\Documents\DocumentUpdatedOrCreatedEvent;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AbstractRepository;
use App\Criteria\EloquentCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;


/**
 * Class DocumentRepository.
 *
 * @package namespace App\Repositories\Documents;
 */
class DocumentRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Document::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
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

        $model = $this->model->newInstance($attributes);
        $model->save();
        $this->resetModel();

        event(new DocumentUpdatedOrCreatedEvent($this, $model));

        return $this->parserResult($model);
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

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

            $this->validator->with($attributes)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new DocumentUpdatedOrCreatedEvent($this, $model));

        return $this->parserResult($model);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $deleted = $model->delete();

        event(new DocumentDeletedEvent($this, $originalModel));

        return $deleted;
    }

    public function setOrder()
    {
        $this->scopeQuery(function($query){
            return $query
                ->orderBy('id', 'asc')
                ->orderBy('name', 'asc')
                ;
        });

        return $this;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
        // App Added sort order name asc as api param
        // For urgent fix - removed sorting criteria
        //$this->pushCriteria(app(EloquentCriteria::class));
        $this->pushCriteria((new DocumentByUserIdCriteria())->setUserId(app('request')->user->id));
    }

    public function presenter()
    {
        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";

    }

    public function validator()
    {
        return "App\\Validators\\Documents\\DocumentValidator";
    }
}
