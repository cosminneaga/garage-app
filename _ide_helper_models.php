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
 * @property string $number
 * @property string $status
 * @property string $service_type
 * @property string $priority
 * @property string|null $appointment_start
 * @property string|null $appointment_finish
 * @property string|null $reminder_sent_at
 * @property string|null $checked_in_at
 * @property string|null $completed_at
 * @property string|null $cancelled_at
 * @property int|null $estimated_duration
 * @property string|null $status_info
 * @property string|null $complaint
 * @property string|null $notes
 * @property string|null $client_notes
 * @property numeric $estimated_cost
 * @property int $client_id
 * @property int $vehicle_id
 * @property int $company_id
 * @property int $advisor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereAdvisorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereAppointmentFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereAppointmentStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCheckedInAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereClientNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereComplaint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereEstimatedCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereEstimatedDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereReminderSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatusInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereVehicleId($value)
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
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @property-read \App\Models\User|null $updater
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedBy($value)
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \App\Models\User|null $updater
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
 * @property int|null $created_by
 * @property int|null $updated_by
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereLandline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedBy($value)
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
 * @property string $extension
 * @property string $path
 * @property \App\Enums\FileType $type
 * @property string|null $description
 * @property int $uploaded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\FileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|File withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFile {}
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceItem> $items
 * @property-read int|null $items_count
 * @method static \Database\Factories\InvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDiscountApplied($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereHourlyCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereWorkTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInvoice {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \App\Enums\JobName $job_name
 * @property string $sku
 * @property int $quantity
 * @property numeric $item_price
 * @property numeric $labour_price
 * @property int $invoice_id
 * @property int $supplier_id
 * @property int $part_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Database\Factories\InvoiceItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereItemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereJobName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereLabourPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem wherePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInvoiceItem {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $manufacturer
 * @property string|null $part_number
 * @property string|null $serial_number
 * @property string|null $code
 * @property string|null $notes
 * @property numeric $item_price
 * @property numeric $commercial_markup
 * @property int $brand
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereCommercialMarkup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereItemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part wherePartNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Part withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPart {}
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
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceItem> $invoiceItems
 * @property-read int|null $invoice_items_count
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\SupplierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedBy($value)
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
 * @property-read User|null $creator
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
 * @property-read User|null $updater
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
 * @property string $vin
 * @property string|null $registration
 * @property string $fuel
 * @property string $status
 * @property int|null $first_visit_odometer
 * @property string|null $first_registration
 * @property string|null $first_visit
 * @property string|null $technical_notes
 * @property string|null $notes
 * @property string|null $diagnostic_information
 * @property int|null $vehicle_make_id
 * @property int|null $vehicle_model_id
 * @property int|null $vehicle_data_id
 * @property int|null $vehicle_year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\VehicleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDiagnosticInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereFirstRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereFirstVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereFirstVisitOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereTechnicalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperVehicle {}
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

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property int $number
 * @property string $status
 * @property int|null $odometer_on_start
 * @property int|null $odometer_on_finish
 * @property string|null $complaint
 * @property string|null $initial_inspection_notes
 * @property string|null $notes
 * @property string|null $part_notes
 * @property numeric $labour_price_hourly
 * @property numeric $labour_total_cost
 * @property numeric $part_total_cost
 * @property int $technician_id
 * @property int $booking_id
 * @property int $company_id
 * @property int $assigned_by
 * @property int $vehicle_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereComplaint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereInitialInspectionNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereLabourPriceHourly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereLabourTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereOdometerOnFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereOdometerOnStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder wherePartNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder wherePartTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereTechnicianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder whereVehicleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workorder withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperWorkorder {}
}

namespace App\Models{
/**
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderLabourTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderLabourTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderLabourTime onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderLabourTime query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderLabourTime withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderLabourTime withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperWorkorderLabourTime {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property int|null $part_installed_odometer
 * @property int|null $expected_life_km
 * @property int|null $expected_life_months
 * @property string|null $notes
 * @property int $workorder_id
 * @property int|null $part_id
 * @property int $performed_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereExpectedLifeKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereExpectedLifeMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation wherePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation wherePartInstalledOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation wherePerformedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation whereWorkorderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkorderOperation withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperWorkorderOperation {}
}

