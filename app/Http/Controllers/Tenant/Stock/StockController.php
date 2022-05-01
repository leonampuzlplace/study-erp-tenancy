<?php

namespace App\Http\Controllers\Tenant\Stock;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Tenant\Stock\StockDto;
use App\Http\Services\Tenant\Stock\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends Controller
{
  public function __construct(
    protected StockService $service
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

  public function store(StockDto $dto): JsonResponse
  {
    return $this->responseSuccess(
      $this->service->store($dto),
      Response::HTTP_CREATED
    );
  }

  public function update(StockDto $dto, int $id): JsonResponse
  {
    return $this->responseSuccess(
      $this->service->update($id, $dto)
    );
  }
}