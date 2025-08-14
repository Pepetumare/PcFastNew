<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class MonitoredPc extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'identifier',
        'user_id',
    ];

    public function metrics(): HasMany
    {
        return $this->hasMany(Metric::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
