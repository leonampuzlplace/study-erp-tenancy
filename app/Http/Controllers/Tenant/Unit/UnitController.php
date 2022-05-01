<?php

namespace App\Http\Controllers\Tenant\Unit;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Tenant\Unit\UnitDto;
use App\Http\Services\Tenant\Unit\UnitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitController extends Controller
{
  public function __construct(
    protected UnitService $service
  ) {
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
}