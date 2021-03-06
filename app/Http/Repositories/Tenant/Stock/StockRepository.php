<?php

namespace App\Http\Repositories\Tenant\Stock;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\BaseRepository;
use App\Models\Tenant\Stock\Stock;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

class StockRepository extends BaseRepository
{
  public function __construct(Stock $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Stock);
  }

  /**
   * Método executado dentro de BaseRepository.index()
   * Adicionar join de tabelas e mostrar colunas específicas
   *
   * @param Builder $queryBuilder
   * @return array
   * Retornar um array contendo queryBuilder e string de colunas a serem exibidas
   */
  public function indexInside(Builder $queryBuilder): array
  {
    return [
      $queryBuilder
        ->leftJoin('unit', 'unit.id', 'stock.unit_id')
        ->leftJoin('category', 'category.id', 'stock.category_id')
        ->leftJoin('brand', 'brand.id', 'stock.brand_id'),
      'stock.*, ' .
      'unit.abbreviation as unit_abbreviation, ' .
      'unit.description  as unit_description, ' .
      'category.name     as category_name, ' .
      'brand.name        as brand_name'
    ];
  }

  /**
   * Localizar um único registro por ID
   * Acrescenta with para mostrar relacionamentos
   *
   * @param integer $id
   * @return Data|null
   */
  public function show(int $id): Data|null
  {
    $modelFound = $this->model
      ->whereId($id)
      ->with('unit')
      ->with('category')
      ->with('brand')
      ->first();

    return $modelFound
      ? $modelFound->getData()
      : null;
  }  
}
