<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\WeekDays;
use App\Helpers\FileStorageHelper;
use App\Models\Address;
use App\Models\CarData;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Part;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\World\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LocalEnv extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. seed role-permissions
        $this->call(PermissionsSeeder::class);

        // 2. check if world database has been seeded
        if (Country::query()->exists()) {
            dump('World database has been seeded. Continuing.');
        } else {
            dump('World database has not been seeded. Please seed using command: composer migrate:world');
            return;
        }

        // $address = Address::create([
        //     'number' => 296,
        //     'name' => 'Flowers Street',
        //     'postcode' => 'B6574JN',
        //     'building' => '1st Building',
        //     'floor' => 3,
        //     'unit' => '4B',
        //     'country_id' => 1,
        //     'state_id' => 1,
        //     'city_id' => 1,
        // ]);

        // dump($address->country->toArray(), $address->state->toArray(), $address->city->toArray());
        // dump($address->country->record->toArray());
        // dump($address->country->timezone->toArray());
        // return;

        Storage::disk('local')->deleteDirectory('users');

        // 3. seed super admin & rest of test users
        $users = User::factory()->createMany([
            [
                'name' => 'Super Admin',
                'email' => 'super@garage.com',
                'password' => 'password',
                'active' => true,
                'image_path' => FileStorageHelper::localReplace('database/assets/PeopleImages/ayoni.jpg', 'users'),
            ],
            [
                'name' => 'Administrator User',
                'email' => 'administrator@garage.com',
                'password' => 'password',
                'active' => true,
                'image_path' => FileStorageHelper::localReplace('database/assets/PeopleImages/george.jpg', 'users'),
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@garage.com',
                'password' => 'password',
                'active' => true,
                'image_path' => FileStorageHelper::localReplace('database/assets/PeopleImages/paula.jpg', 'users'),
            ],
            [
                'name' => 'User',
                'email' => 'user@garage.com',
                'password' => 'password',
                'image_path' => FileStorageHelper::localReplace('database/assets/PeopleImages/joseph.jpg', 'users'),
            ],
        ]);

        // 4. assign roles & create team
        $users[0]->assignRole(UserRole::SUPER);
        $users[1]->assignRole(UserRole::ADMINISTRATOR);
        $users[2]->assignRole(UserRole::MANAGER);
        $users[3]->assignRole(UserRole::USER);
        $users[1]->memberAttach($users[2]);
        $users[2]->memberAttach($users[3]);

        // 5. creating & attaching addresses & contacts
        $users[0]->addresses()->attach(Address::factory()->create([
            'country_id' => 1,
            'state_id' => 1,
            'city_id' => 1,
        ]));
        $users[0]->contacts()->attach(Contact::factory()->create());
        $users[1]->addresses()->attach(Address::factory()->create([
            'country_id' => 1,
            'state_id' => 2,
            'city_id' => 2,
        ]));
        $users[1]->contacts()->attach(Contact::factory()->create());
        $users[2]->addresses()->attach(Address::factory()->create([
            'country_id' => 1,
            'state_id' => 2,
            'city_id' => 2,
        ]));
        $users[2]->contacts()->attach(Contact::factory()->create());
        $users[3]->addresses()->attach(Address::factory()->create([
            'country_id' => 1,
            'state_id' => 2,
            'city_id' => 2,
        ]));
        $users[3]->contacts()->attach(Contact::factory()->create());

        // 6. creating & attach company to users
        $company = Company::factory()->create([
            'name' => 'Koepp PLC',
            'labour_rate_hourly' => 40.00,
            'tax_value' => 20.00,
            'invoice_prefix' => 'KOEPP',
        ]);
        $company->addresses()->attach(Address::factory()->create([
            'country_id' => 1,
            'state_id' => 2,
            'city_id' => 2,
        ]));
        $company->contacts()->attach(Contact::factory()->create());
        $company->users()->attach([$users[1], $users[2], $users[3]]);

        // 7. create first company default schedule
        $company->schedules()->createMany([
            [
                'name' => WeekDays::MONDAY,
                'start' => '08:00',
                'end' => '17:00',
            ],
            [
                'name' => WeekDays::TUESDAY,
                'start' => '08:00',
                'end' => '17:00',
            ],
            [
                'name' => WeekDays::WEDNESDAY,
                'start' => '08:00',
                'end' => '17:00',
            ],
            [
                'name' => WeekDays::THURSDAY,
                'start' => '08:00',
                'end' => '17:00',
            ],
            [
                'name' => WeekDays::FRIDAY,
                'start' => '08:00',
                'end' => '17:00',
            ],
            [
                'name' => WeekDays::SATURDAY,
                'start' => '10:00',
                'end' => '14:00',
            ],
            [
                'name' => WeekDays::SUNDAY,
                'start' => null,
                'end' => null,
            ],
        ]);

        // 8. create & set default_company for created users
        $users[1]->settings()->create([
            'default_company' => $company->id,
        ]);
        $users[2]->settings()->create([
            'default_company' => $company->id,
        ]);
        $users[3]->settings()->create([
            'default_company' => $company->id,
        ]);

        // 9. create supplier & attach to company
        $supplier = Supplier::factory()->create();
        $supplier->addresses()->attach(Address::factory()->create([
            'country_id' => 10,
            'state_id' => 10,
            'city_id' => 10,
        ]));
        $supplier->contacts()->attach(Contact::factory()->create());
        $company->suppliers()->attach($supplier);


        // 7. create client with address & contact & attach to company
        $client = Client::factory()->create();
        $client->addresses()->attach(Address::factory()->create([
            'country_id' => 1,
            'state_id' => 2,
            'city_id' => 2,
        ]));
        $client->contacts()->attach(Contact::factory()->create());
        $company->clients()->attach($client);

        // 8. create vehicle & attach to company
        $vehicle = Vehicle::factory()->create();
        $company->vehicles()->attach($vehicle);

        // 9. create default cars
        $carMake = CarMake::factory()->create(['name' => 'BMW']);
        $carModel = CarModel::factory()->create([
            'make_id' => $carMake->id,
            'name' => 'E60 530D',
            'class' => 'Sport',
        ]);
        $carData = CarData::factory()->create([
            'make_id' => $carMake->id,
            'model_id' => $carModel->id,
            'name' => '7-Speed Automatic, Rear-Wheel Drive, 6 cylinders inline, 3.0L',
            'cylinders' => 6,
            'displacement' => 3.0,
            'drive' => 'Rear-Wheel Drive (RWD)',
            'transmission' => 'Automatic',
        ]);
        $vehicle->update([
            'make_id' => $carMake->id,
            'model_id' => $carModel->id,
            'data_id' => $carData->id,
        ]);

        // 10. create parts & attach to suupplier
        Part::factory(10)->create(['supplier_id' => $supplier->id, 'brand' => $carMake->id]);
    }
}
