<x-mail::message>
# {{ $title }}

{{ $message }}

<x-mail::button :url="$url">
    Go to Workorder
</x-mail::button>

Best regards,<br>
Garage Application Team
</x-mail::message>
