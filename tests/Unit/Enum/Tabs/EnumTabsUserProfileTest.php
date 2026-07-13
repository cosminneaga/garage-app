<?php

declare(strict_types=1);

use App\Enums\Tabs\UserProfileTabs;

test('ui', function () {
    expect(UserProfileTabs::ui())->toMatchArray([
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
        [
            'value' => 'settings',
            'label' => 'Settings',
            'slug' => 'settings',
        ],
    ]);
});
