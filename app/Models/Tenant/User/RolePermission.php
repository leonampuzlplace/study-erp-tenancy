<?php

namespace App\Models\Tenant\User;

use App\Http\DataTransferObjects\Tenant\User\RolePermissionDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class RolePermission extends Model
{
    use HasFactory;
    use WithData;
    
    protected $table = 'role_permission';
    protected $dataClass = RolePermissionDto::class;
    public $timestamps = false;

    protected $hidden = [
    ];

    protected $casts = [
        'is_allowed' => 'boolean',
    ];

    protected $fillable = [
        'role_id',
        'action_name',
        'action_group_description',
        'action_name_description',
        'is_allowed',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados antes de recuperar a informação
        static::retrieved(fn ($model) => $model);
    }
}
