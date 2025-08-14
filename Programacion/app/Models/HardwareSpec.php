<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareSpec extends Model
{
    use HasFactory;
    protected $fillable = ['monitored_pc_id', 'cpu', 'ram_total_gb', 'disks', 'motherboard'];
    protected $casts = ['disks' => 'array']; // Laravel tratará el campo 'disks' como un array
    public function monitoredPc()
    {
        return $this->belongsTo(MonitoredPc::class);
    }
}
