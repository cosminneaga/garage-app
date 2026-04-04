<?php

declare(strict_types=1);

namespace App\Models;

// use Database\Factories\SupplierFactory;
use App\Enums\SupplierType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Supplier extends Model
{
    /** @use HasFactory<SupplierFactory> */
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'code',
        'type',
        'tax_id',
        'registration_number',
    ];

    protected $casts = [
        'type' => SupplierType::class,
    ];

    protected $attributes = [
        'type' => SupplierType::DISTRIBUTOR->value,
    ];

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function repairInvoiceItems(): HasMany
    {
        return $this->hasMany(RepairInvoiceItem::class);
    }
}
