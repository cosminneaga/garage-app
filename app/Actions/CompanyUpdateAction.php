<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Company;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyUpdateAction
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes, Company $company): void
    {
        $data = [];

        $data['company'] = collect($attributes)
            ->only([
                'name',
                'tax_id',
                'registration_number',
                'tax_value',
                'invoice_prefix',
            ])
            ->toArray();

        if (Arr::has($attributes, 'image') && $attributes['image'] !== null) {
            $data['company']['image_path'] = $attributes['image']->store('companies', 'public');
        }

        DB::transaction(function () use ($data, $company) {
            // replace old image with new one
            if (Arr::has($data, 'company.image_path') && ($company->image_path && Storage::disk('public')->exists($company->image_path))) {
                Storage::disk('public')->delete($company->image_path);
            }

            $company->update($data['company']);
        });
    }
}
