<?php

namespace Moudles\Http\Controllers\LogsWebController;

use App\Http\Controllers\Controller;
use Modules\Logs\Services\LogService;
use Illuminate\Http\JsonResponse;
use Modules\Logs\Http\Requests\LogReuest;

class LogsRestController extends Controller
{

    /**
     * @var LogService service
     */
    private LogService $service;

    /**
     * __construct
     *
     * @param LogService service
     *
     * @return void
     */
    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    /**
     * findAll
     *
     * @return JsonResponse
     */
    public function findAll() : JsonResponse
    {
        $data = $this->service->findAll();
        return response()->json(
            ['content' => $data['content'], 'errors' => $data['errors']],
            $data['code']
        );
    }

    /**
     * findById
     *
     * @param int id
     *
     * @return JsonResponse
     */
    public function findById(int $id) : JsonResponse
    {
        $data = $this->service->findById($id);
        return response()->json(
            ['content' => $data['content'], 'errors' => $data['errors']],
            $data['code']
        );
    }

    /**
     * store
     *
     * @param LogReuest request
     *
     * @return JsonResponse
     */
    public function store(LogReuest $request) : JsonResponse
    {
        $data = $this->service->store($request->all());
        return response()->json(
            ['content' => $data['content'], 'errors' => $data['errors']],
            $data['code']
        );
    }
}
