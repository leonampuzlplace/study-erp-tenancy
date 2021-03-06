<?php

namespace App\Http\Services\Tenant\Stock;

use App\Http\DataTransferObjects\Tenant\Stock\StockDto;
use App\Http\Repositories\Tenant\Stock\StockRepository;
use App\Http\Services\Tenant\User\RoleService;

class StockService
{
  public function __construct(
    protected StockRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(StockRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): StockDto|null
  {
    return $this->repository->show($id);
  }

  public function store(StockDto $dto): StockDto
  {
    return $this->repository->setTransaction(false)->store($dto);
  }

  public function update(int $id, StockDto $dto): StockDto
  {
    return $this->repository->setTransaction(false)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('stock', 'Produtos / Serviços');
  }  
}