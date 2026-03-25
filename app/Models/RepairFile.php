<?php

namespace App\Models;

// use Database\Factories\RepairFileFactory;
use App\FileStatus;
use App\RepairStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairFile extends Model
{
    /** @use HasFactory<RepairFileFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'name',
        'path',
        'type',
        'repair_status',
        'status',
    ];

    protected $casts = [
        'status' => FileStatus::class,
        'repair_status' => RepairStatus::class,
    ];

    protected $attributes = [
        'status' => FileStatus::BEFORE->value,
        'repair_status' => RepairStatus::RECEPTION->value,
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }
}
