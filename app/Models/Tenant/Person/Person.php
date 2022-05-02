<?php

namespace App\Models\Tenant\Person;

use App\Http\DataTransferObjects\Tenant\Person\PersonDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Person extends Model
{
    use HasFactory;
    use WithData;
        
    protected $table = 'person';
    protected $dates = ['deleted_at'];
    protected $dataClass = PersonDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [
        'icms_taxpayer' => 'boolean',
        'is_customer' => 'boolean',
        'is_seller' => 'boolean',
        'is_supplier' => 'boolean',
        'is_carrier' => 'boolean',
        'is_technician' => 'boolean',
        'is_employee' => 'boolean',
        'is_other' => 'boolean',
    ];

    protected $fillable = [
        'business_name',
        'alias_name',
        'ein',
        'state_registration',
        'icms_taxpayer',
        'municipal_registration',
        'note',
        'internet_page',
        'is_customer',
        'is_seller',
        'is_supplier',
        'is_carrier',
        'is_technician',
        'is_employee',
        'is_other',
      ];

    protected static function boot()
    {
        parent::boot();
        
        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model->ein = onlyNumbers($model->ein ?? ''));

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);        
    }    

    public function personAddress()
    {
        return $this->hasMany(PersonAddress::class);
    }

    public function personContact()
    {
        return $this->hasMany(PersonContact::class);
    }
}
