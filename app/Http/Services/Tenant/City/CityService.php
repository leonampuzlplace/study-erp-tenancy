<?php

namespace App\Http\Services\Tenant\City;

use App\Http\DataTransferObjects\Tenant\City\CityDto;
use App\Http\Repositories\Tenant\City\CityRepository;

class CityService
{
  public function __construct(
    protected CityRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(CityRepository::make());
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): CityDto
  {
    return $this->repository->show($id);
  }
}
