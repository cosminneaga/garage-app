<?php

declare(strict_types=1);

use App\Enums\Tabs\SupplierTabs;

test('ui', function () {
    expect(SupplierTabs::ui())->toMatchArray([
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
            'value' => 'contacts',
            'label' => 'Contacts',
            'slug' => 'contacts',
        ],
        [
            'value' => 'addresses',
            'label' => 'Addresses',
            'slug' => 'addresses',
        ],
    ]);
});
