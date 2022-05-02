<?php

namespace App\Http\Controllers\Tenant\User;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Tenant\User\RoleDto;
use App\Http\Services\Tenant\User\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
    * Constructor
    *
    * @param RoleService $service
    */
    public function __construct(
        protected RoleService $service
    ) {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->responseSuccess(code: Response::HTTP_NO_CONTENT);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->responseSuccess(
        $this->service->index(
            $request->input('page'),
            $request->input('filter'),
        )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->show($id)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleDto $dto
     * @return \Illuminate\Http\Response
     */
    public function store(RoleDto $dto): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->store($dto),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleDto $dto
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(RoleDto $dto, int $id): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->update($id, $dto)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function permissionTemplate(): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->permissionTemplate()
        );
    }    
}
