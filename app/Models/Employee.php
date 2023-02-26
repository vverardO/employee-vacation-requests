<?php

namespace App\Models;

use App\Enums\GendersEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'gender',
        'general_record',
        'registration_physical_person',
        'company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gender' => GendersEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected function birthDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => (! $this->birth_date) ? 'Não informada' : $this->birth_date->format('d/m/Y'),
        );
    }

    public function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('d/m/Y H:i:s'),
        );
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }
}
