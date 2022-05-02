<?php

namespace App\Models\Tenant\Person;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonContact extends Model
{
    use HasFactory;

    protected $table = 'person_contact';
    public $timestamps = false;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected $fillable = [
        'person_id',
        'is_default',
        'name',
        'ein',
        'type',
        'note',
        'phone',
        'email',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model->ein = onlyNumbers($model->ein));

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model->ein = formatCpfCnpj($model->ein));
    }    
}
