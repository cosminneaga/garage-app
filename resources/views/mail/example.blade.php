<x-mail::message>
# {{ $title }}

Example notification using booking created resource.

<x-mail::button :url="$url">
View Booking
</x-mail::button>

<x-mail::table>
| Laravel       | Table         | Example       |
| ------------- | :-----------: | ------------: |
| Col 2 is      | Centered      | $10           |
| Col 3 is      | Right-Aligned | $20           |
</x-mail::table>

- Booking_id: {{ $booking_id }}
- Booking_number: {{ $booking_number }}
- TEST: {{ $test }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
