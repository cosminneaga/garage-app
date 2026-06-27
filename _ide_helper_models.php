<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $street_number
 * @property string $street
 * @property string $postcode
 * @property string|null $building
 * @property string|null $floor
 * @property string|null $unit
 * @property \App\Dto\Coordinates|null $coordinates
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address withCoordinates()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAddress {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $on
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Repair> $repairs
 * @property-read int|null $repairs_count
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBooking {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $active
 * @property string $password
 * @property string|null $access_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Repair> $repairs
 * @property-read int|null $repairs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutTeam($teams)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperClient {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $tax_id
 * @property string $registration_number
 * @property float $tax_value
 * @property string $invoice_prefix
 * @property string|null $image_path
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Repair> $repairs
 * @property-read int|null $repairs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\CompanyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereInvoicePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCompany {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $mobile
 * @property string|null $landline
 * @property string|null $email
 * @property string|null $url
 * @property string|null $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereLandline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperContact {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $address
 * @property-read int|null $address_count
 * @method static \Database\Factories\CountryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCountry {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepairInvoiceItem> $repairInvoiceItems
 * @property-read int|null $repair_invoice_items_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProduct {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $registration
 * @property string $vin
 * @property int $odometer
 * @property \App\Enums\FuelType $fuel
 * @property \App\Enums\RepairStatus $status
 * @property string|null $complaint_description
 * @property string|null $initial_inspection
 * @property string|null $diagnosis_notes
 * @property string|null $work_order
 * @property string|null $parts_required
 * @property string|null $execution_data
 * @property string|null $labour_tracking_data
 * @property string|null $quality_check_testing
 * @property string|null $service_record
 * @property int $booking_id
 * @property int $vehicle_data_id
 * @property int $company_id
 * @property int $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Booking|null $booking
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\VehicleData|null $data
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepairFile> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepairInvoice> $invoices
 * @property-read int|null $invoices_count
 * @method static \Database\Factories\RepairFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereComplaintDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereDiagnosisNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereExecutionData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereInitialInspection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereLabourTrackingData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair wherePartsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereQualityCheckTesting($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereServiceRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereVehicleDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair whereWorkOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Repair withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRepair {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property string $path
 * @property string $type
 * @property \App\Enums\FileStatus $status
 * @property \App\Enums\RepairStatus $repair_status
 * @property string|null $description
 * @property int $repair_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Repair|null $repair
 * @method static \Database\Factories\RepairFileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereRepairId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereRepairStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairFile withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRepairFile {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $invoice_number
 * @property numeric $work_time
 * @property numeric $hourly_charge
 * @property \App\Enums\InvoiceStatus $status
 * @property numeric $discount_applied
 * @property numeric $paid_amount
 * @property string|null $description
 * @property int $repair_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepairInvoiceItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Repair|null $repair
 * @method static \Database\Factories\RepairInvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereDiscountApplied($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereHourlyCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereRepairId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereWorkTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRepairInvoice {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \App\Enums\JobName $job_name
 * @property string $sku
 * @property int $quantity
 * @property numeric $item_price
 * @property numeric $labour_price
 * @property int $repair_invoice_id
 * @property int $supplier_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\RepairInvoice|null $invoice
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Database\Factories\RepairInvoiceItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereItemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereJobName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereLabourPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereRepairInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoiceItem withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRepairInvoiceItem {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property \App\Enums\SupplierType $type
 * @property string $tax_id
 * @property string $registration_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RepairInvoiceItem> $repairInvoiceItems
 * @property-read int|null $repair_invoice_items_count
 * @method static \Database\Factories\SupplierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSupplier {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $manager_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTeam {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $image_path
 * @property string $password
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $managers
 * @property-read int|null $managers_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $cylinders
 * @property float $displacement
 * @property string $drive
 * @property string $transmission
 * @property int $vehicle_make_id
 * @property int $vehicle_model_id
 * @property int $vehicle_year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\VehicleMake|null $make
 * @property-read \App\Models\VehicleModel|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Repair> $repairs
 * @property-read int|null $repairs_count
 * @property-read \App\Models\VehicleYear|null $year
 * @method static \Database\Factories\VehicleDataFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereCylinders($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereDisplacement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereDrive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereVehicleYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperVehicleData {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleData> $data
 * @property-read int|null $data_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleModel> $models
 * @property-read int|null $models_count
 * @method static \Database\Factories\VehicleMakeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperVehicleMake {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $vehicle_make_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleData> $data
 * @property-read int|null $data_count
 * @property-read \App\Models\VehicleMake|null $make
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleYear> $years
 * @property-read int|null $years_count
 * @method static \Database\Factories\VehicleModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleModel withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperVehicleModel {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $year
 * @property int $vehicle_model_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleData> $data
 * @property-read int|null $data_count
 * @property-read \App\Models\VehicleModel|null $model
 * @method static \Database\Factories\VehicleYearFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperVehicleYear {}
}

