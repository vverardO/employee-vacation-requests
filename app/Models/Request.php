<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Carbon\Carbon;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use HasFactory;
    use Timestamp;

    protected $fillable = [
        'number',
        'title',
        'start',
        'end',
        'company_id',
        'status',
        'employee_id',
        'request_type_id',
        'created_by',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
    ];

    protected $dates = [
        'start',
        'end',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'status' => RequestStatus::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function startFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromFormat('Y-m-d', $this->start)->format('d/m/Y'),
        );
    }

    public function endFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromFormat('Y-m-d', $this->end)->format('d/m/Y'),
        );
    }

    public function approvedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->approved_at ?? Carbon::createFromFormat('Y-m-d', $this->approved_at)->format('d/m/Y'),
        );
    }

    public function rejectedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->rejected_at ?? Carbon::createFromFormat('Y-m-d', $this->rejected_at)->format('d/m/Y'),
        );
    }

    public function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y'),
        );
    }

    public function isOpened(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === RequestStatus::Opened,
        );
    }

    public function isRejected(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === RequestStatus::Rejected,
        );
    }

    public function isApproved(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === RequestStatus::Approved,
        );
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }

    public function scopeRelatedToUser(Builder $query): void
    {
        if (Role::USER == auth()->user()->role->title) {
            $query->where('created_by', auth()->user()->id);
        }
    }

    public function canBeUpdated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === RequestStatus::Opened,
        );
    }
}
