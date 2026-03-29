<?php

namespace App\Models;

// use Database\Factories\RepairFileFactory;
use App\Enums\FileStatus;
use App\Enums\RepairStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairFile extends Model
{
    /** @use HasFactory<RepairFileFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'extension',
        'path',
        'type',
        'status',
        'repair_status',
        'description',
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
