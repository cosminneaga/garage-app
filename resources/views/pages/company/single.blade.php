<x-layout>
    <h2 class="text-2xl">{{ $company->name }}</h2>

    <p>Registration: {{ $company->registration_no }}</p>
    <p>Tax value: {{ $company->tax_value }}</p>
    <p>Invoice prefix: {{ $company->invoice_prefix }}</p>

    <h3 class="text-xl">Members</h3>
    <ul class="list-decimal">
        @foreach ($company->users()->get() as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>

    <h3 class="text-xl">Addresses</h3>
    <ul class="list-point">
        @foreach ($company->addresses()->get() as $address)
            <li>Street: {{ $address->street }}</li>
            <li>Number: {{ $address->number }}</li>
            <li>Postcode: {{ $address->postcode }}</li>
            <li>Extra: {{ $address->extra }}</li>
            <li>Country: {{ $address->country->name }}</li>
            {{-- <li>Coordinates: {{ $address->coordinatesAsBinary() }}</li> --}}
        @endforeach
    </ul>

    {{-- @dump($company->addresses()->get()) --}}
</x-layout>
