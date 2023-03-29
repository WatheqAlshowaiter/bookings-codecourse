<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'client_name',
        'client_email',
        'cancelled_at',
    ];

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = str()->uuid();
            $model->token = str()->random(32);
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeNotCancelled(Builder $builder)
    {
        $builder->whereNull('cancelled_at');
    }

    public function isCancelled()
    {
        return ! is_null($this->cancelled_at);
    }
}
