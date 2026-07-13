<?php

declare(strict_types=1);

use App\Enums\Tabs\CompanyTabs;

test('ui', function () {
    expect(CompanyTabs::ui())->toMatchArray([
        [
            'value' => 'details',
            'label' => 'Details',
            'slug' => 'details',
        ],
        [
            'value' => 'statistics',
            'label' => 'Statistics',
            'slug' => 'statistics',
        ],
        [
            'value' => 'members',
            'label' => 'Members',
            'slug' => 'members',
        ],
        [
            'value' => 'contacts',
            'label' => 'Contacts',
            'slug' => 'contacts',
        ],
        [
            'value' => 'addresses',
            'label' => 'Addresses',
            'slug' => 'addresses',
        ],
        [
            'value' => 'suppliers',
            'label' => 'Suppliers',
            'slug' => 'suppliers',
        ],
    ]);
});
