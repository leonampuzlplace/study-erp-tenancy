<?php

namespace App\Http\Repositories\Tenant\Unit;

use App\Http\Repositories\BaseRepository;
use App\Models\Tenant\Unit\Unit;

class UnitRepository extends BaseRepository
{
  public function __construct(Unit $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Unit);
  }
}
