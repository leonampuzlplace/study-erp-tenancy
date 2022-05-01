<?php

namespace App\Http\Controllers\Tenant\Brand;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Tenant\Brand\BrandDto;
use App\Http\Services\Tenant\Brand\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Undocumented function
     *
     * @param BrandService $service
     */
    public function __construct(
        protected BrandService $service
    ) {
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->responseSuccess(code: Response::HTTP_NO_CONTENT);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->index(
                $request->input('page'),
                $request->input('filter'),
            )
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->show($id)
        );
    }

    public function store(BrandDto $dto): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->store($dto),
            Response::HTTP_CREATED
        );
    }

    /**
     * Undocumented function
     *
     * @param BrandDto $dto
     * @param integer $id
     * @return JsonResponse
     */
    public function update(BrandDto $dto, int $id): JsonResponse
    {
        return $this->responseSuccess(
            $this->service->update($id, $dto)
        );
    }
}
