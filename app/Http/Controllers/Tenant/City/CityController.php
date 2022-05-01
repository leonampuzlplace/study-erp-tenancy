<?php

namespace App\Http\Controllers\Tenant\City;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Tenant\City\CityDto;
use App\Http\Services\Tenant\City\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
  public function __construct(
    protected CityService $service
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
