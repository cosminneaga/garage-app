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
        $country = Country::first();

        // 3. addresses & contact, 10
        $contact = Contact::factory(10)->create();
        $address = Address::factory(10)->create([
            'country_id' => $country,
        ]);

        // 4. seed users & attach contacts & addresses + role assignation
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $manager = User::factory()->create([
            'name' => 'User Manager',
            'email' => 'manager@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $superAdmin->addresses()->attach($address[0]);
        $superAdmin->contacts()->attach($contact[0]);
        $superAdmin->assignRole(UserRole::SUPER);

        // 5. creating & adding super team member
        $superTeamMember = User::factory()->create([
            'name' => 'Super Team member',
            'active' => true,
        ]);
        $superAdmin->team()->attach($superTeamMember);

        // 5. adding user manager
        $manager->addresses()->attach($address[1]);
        $manager->contacts()->attach($contact[1]);
        $manager->assignRole(UserRole::USER_ADMIN);

        // 5. adding team members
        $teamMembers = User::factory(20)->create();
        $groups = $teamMembers->splitIn(2);
        $groups[0]->each(function ($item) use ($contact, $address) {
            $item->assignRole(UserRole::USER_EDITOR);
            $item->contacts()->attach($contact);
            $item->addresses()->attach($address);
        });
        $groups[1]->each(fn ($item) => $item->assignRole(UserRole::USER_VIEWER));
        $manager->team()->attach($teamMembers);

        // ! avoid seeding vehicle data due to large sets of data being inserted into DB

        // 6. create suppliers, 30
        $suppliers = Supplier::factory(30)->create();
        $suppliers[0]->addresses()->attach($address[2]);
        $suppliers[0]->addresses()->attach($address[3]);
        $suppliers[0]->contacts()->attach($contact[2]);
        $suppliers[0]->contacts()->attach($contact[3]);

        // 7. create company -- attach 'address' & 'contact' & 'supplier'
        $company = Company::factory()->create();
        $company->addresses()->attach($address[4]);
        $company->contacts()->attach($contact[4]);
        $company->suppliers()->attach($suppliers[0]);
        $company->users()->attach($superAdmin);

        $company_nd = Company::factory(135)->create();
        $company_nd[0]->addresses()->attach($address[5]);
        $company_nd[0]->contacts()->attach($contact[5]);
        $company_nd[0]->suppliers()->attach(collect($suppliers)->slice(1));
        foreach ($company_nd as $cp) {
            $cp->users()->attach($manager);
        }

        // 8. create client, attach addresses & contacts
        $client = Client::factory()->create();
        $client->companies()->attach($company_nd[0]);
        $client->addresses()->attach($address[6]);
        $client->contacts()->attach($contact[6]);

        // 9. create repair with assignation on 'company_id' -- this will also create
        // clients, bookings, vehicle data
        $repair = Repair::factory()->create([
            'company_id' => $company_nd[0],
            'client_id' => $client,
        ]);

        // 10. create repair file, 20
        $repairFile = RepairFile::factory(20)->create([
            'repair_id' => $repair,
        ]);

        // 11. create repair invoice, 5
        $repairInvoice = RepairInvoice::factory(5)->create([
            'repair_id' => $repair,
        ]);

        // 12. create repair items, 30
        RepairInvoiceItem::factory(30)->create([
            'repair_invoice_id' => $repairInvoice[0],
            'supplier_id' => $suppliers[1],
        ]);
    }
}
