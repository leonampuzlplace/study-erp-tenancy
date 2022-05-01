<?php

namespace App\Models\Tenant\Person;

use App\Models\Tenant\City\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonAddress extends Model
{
    use HasFactory;

    protected $table = 'person_address';
    public $timestamps = false;
    protected $hidden = [];

    protected $casts = [
        'is_default' => 'boolean',
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

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
