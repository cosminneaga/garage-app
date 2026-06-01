<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Repair;
use App\Models\RepairFile;
use App\Models\RepairInvoice;
use App\Models\RepairInvoiceItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocalEnv extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. seed role-permissions
        $this->call(PermissionsSeeder::class);

        // 2. seed countries
        $this->call(CountriesSeeder::class);
        $country = Country::first(['*']);

        // 3. addresses & contact, 10
        $contact = Contact::factory(10)->create();
        $address = Address::factory(10)->create([
            'country_id' => $country,
        ]);

        // 4. seed super admin & attach contacts & addresses, role assignation + team members
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $superAdmin->assignRole(UserRole::SUPER);
        $superAdmin->addresses()->attach($address[0]);
        $superAdmin->contacts()->attach($contact[0]);
        $superTeamMember = User::factory()->create([
            'name' => 'Super Team member',
            'active' => true,
        ]);
        $superAdmin->team()->attach($superTeamMember);

        // 4.1 adding testing admin company
        $adminCompany = Company::factory()->create();
        $adminCompany->addresses()->attach($address[4]);
        $adminCompany->contacts()->attach($contact[4]);
        $adminCompany->users()->attach($superAdmin);

        // 5. adding user manager, attach contact & address, role assignation
        $manager = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $manager->assignRole(UserRole::USER_ADMIN);
        $manager->addresses()->attach($address[1]);
        $manager->contacts()->attach($contact[1]);

        // 5.1 adding second manager attached to the first manager
        $manager2 = User::factory()->create([
            'name' => 'Manager2 User',
            'email' => 'manager2@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $manager2->assignRole(UserRole::USER_ADMIN);
        $manager2->addresses()->attach($address[1]);
        $manager2->contacts()->attach($contact[1]);
        $manager->team()->attach($manager2);

        // 6. adding editor team member, attach contact & address, role assignation
        $editorUser = User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $editorUser->assignRole(UserRole::USER_EDITOR);
        $editorUser->addresses()->attach($address[2]);
        $editorUser->contacts()->attach($contact[2]);
        $manager->team()->attach($editorUser);
        $manager2->team()->attach($editorUser);

        // 7. adding viewer team member
        $viewerUser = User::factory()->create([
            'name' => 'Viewer User',
            'email' => 'viewer@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $viewerUser->assignRole(UserRole::USER_VIEWER);
        $viewerUser->addresses()->attach($address[3]);
        $viewerUser->contacts()->attach($contact[3]);
        $manager->team()->attach($viewerUser);
        $manager2->team()->attach($viewerUser);

        // 8. adding related company for all team members
        $teamCompany = Company::factory()->create([
            'name' => 'Seeded Company Name LTD',
        ]);
        $teamCompany->addresses()->attach($address[4]);
        $teamCompany->contacts()->attach($contact[4]);
        $teamCompany->users()->attach([$manager, $manager2, $editorUser, $viewerUser]);

        // 9. adding related supplier for given company
        $supplier = Supplier::factory()->create([
            'name' => 'Seeded Supplier Name LTD',
        ]);
        $supplier->addresses()->attach($address[5]);
        $supplier->contacts()->attach($contact[5]);
        $supplier->companies()->attach($teamCompany);

        // 8. create client, attach addresses & contacts
        $client = Client::factory()->create();
        $client->companies()->attach($teamCompany);
        $client->addresses()->attach($address[6]);
        $client->contacts()->attach($contact[6]);

        // 9. create repair with assignation on 'company_id' -- this will also create
        // clients, bookings, vehicle data
        $repair = Repair::factory()->create([
            'company_id' => $teamCompany,
            'client_id' => $client,
        ]);

        // 10. create repair file, 20
        RepairFile::factory(20)->create([
            'repair_id' => $repair,
            'type' => 'image/png',
        ]);

        // 11. create repair invoice, 5
        $repairInvoice = RepairInvoice::factory(5)->create([
            'repair_id' => $repair,
        ]);

        // 12. create repair items, 30
        RepairInvoiceItem::factory(30)->create([
            'repair_invoice_id' => $repairInvoice[0],
            'supplier_id' => $supplier,
        ]);

        // 13. adding some more companies to given manager
        $managerCompanies = Company::factory(9)->create();
        $manager->companies()->attach($managerCompanies);

        // 14. adding companies that are not attached to created users
        Company::factory(10)->create();
    }
}
