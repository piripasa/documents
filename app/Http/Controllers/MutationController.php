<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AbstractRepository;

class MutationController extends Controller
{
   /**
     * @var Repository
     */
    protected $repository;

    public function __construct(AbstractRepository $repository) {
        $this->repository = $repository;
    }

    public function index($id = null, $callback = null)
    {
        $repository = $this->repository;
        if($callback instanceof \Closure) {
            $repository = $callback($this->repository);
        }

        if(app('request')->get('page') == 'all') {
            return response()->json($repository->all());
        }

        $response = empty($id) ? $repository->setOrder()->paginate() : $repository->find($id)['data']
        ;

        if( isset($response['meta']['pagination']) && empty($response['meta']['pagination']['links'])) {
            $response['meta']['pagination']['links'] = new \StdClass();
        }

        $response['meta']['showCount'] = (int)env('SHOW_COUNT', 1);

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $result = $this
            ->repository
            ->create($request->all())
        ;

        return $this->response($result['data']['id']);
    }

    public function update(Request $request, $id)
    {
        $this
            ->repository
            ->update($request->all(), $id)
        ;

        return $this->response($id);
    }

    public function delete($id)
    {
        $response = $this->repository->delete($id);

        return $this->response($id);
    }

    public function response($id)
    {
        $method = debug_backtrace()[1]['function'];
        $controller = strtolower(substr((new \ReflectionClass($this))->getShortName(), 0, -10));

        return response()->json(array(
            'id' => $id,
            'success' => true,
            'message' => app('translator')
                ->trans(sprintf(
                    'messages.%s.%s', $controller, $method
                ))
        ));
    }
}
