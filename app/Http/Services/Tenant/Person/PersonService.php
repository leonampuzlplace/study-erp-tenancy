<?php

namespace App\Http\Services\Tenant\Person;

use App\Http\DataTransferObjects\Tenant\Person\PersonDto;
use App\Http\Repositories\Tenant\Person\PersonRepository;
use App\Http\Services\Tenant\User\RoleService;

class PersonService
{
  public function __construct(
    protected PersonRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(PersonRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): PersonDto|null
  {
    return $this->repository->show($id);
  }

  public function store(PersonDto $dto): PersonDto|null
  {
    return $this->repository->setTransaction(true)->store($dto);
  }

  public function update(int $id, PersonDto $dto): PersonDto
  {
    return $this->repository->setTransaction(true)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('person', 'Pessoas');
  }  
}