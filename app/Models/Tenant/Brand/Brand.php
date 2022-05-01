<?php

namespace App\Models\Tenant\Brand;

use App\Http\DataTransferObjects\Tenant\Brand\BrandDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Brand extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'brand';
    protected $dates = ['deleted_at'];
    protected $dataClass = BrandDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [
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
}
