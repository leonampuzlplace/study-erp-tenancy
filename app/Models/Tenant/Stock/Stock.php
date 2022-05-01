<?php

namespace App\Models\Tenant\Stock;

use App\Http\DataTransferObjects\Tenant\Stock\StockDto;
use App\Models\Tenant\Brand\Brand;
use App\Models\Tenant\Category\Category;
use App\Models\Tenant\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Stock extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'stock';
    protected $dates = ['deleted_at'];
    protected $dataClass = StockDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [
        'is_service' => 'boolean',
        'cost_price' => 'float',
        'sale_price' => 'float',
        'minimum_quantity' => 'float',
        'current_quantity' => 'float',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
