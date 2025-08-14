<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = [
        'pc_identifier',
        'cpu_usage',
        'ram_usage',
        'disk_usage',
        'cpu_temperature',
    ];

    public function monitoredPc(): BelongsTo
    {
        return $this->belongsTo(MonitoredPc::class);
    }
}
