<x-mail::message>
# {{ $title }}

@foreach ($messages as $message)
<p>{{ $message }}</p>
@endforeach

<x-mail::button :url="$url">
Go to booking
</x-mail::button>

Best regards,<br>
Garage Application Team
</x-mail::message>
