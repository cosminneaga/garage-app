<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->company = Company::factory()->create(['name' => 'Company']);

    $this->administrator->companies()->attach($this->company);
    $this->company->delete();
});

test('administrator: should restore removed company', function () {
    actingAs($this->administrator);

    visit(route('companies.removed'))
        ->assertSee('Company')
        ->click('@company-restore-' . $this->company->id . '-modal-trigger')
        ->click('@company-restore-' . $this->company->id . '-modal-confirm')
        ->assertSee('Company restored')
        ->assertSee('The company has been successfully restored and is now available in your account')
        ->assertDontSee('Company');
});
