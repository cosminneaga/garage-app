<x-layout>
    <ul class="list-decimal!">
        @foreach ($companies as $company)
            <li><a
                    href="{{ route('company.show', $company) }}"
                    rel="noopener noreferrer"
                >{{ $company->name }}</a></li>
        @endforeach
    </ul>
</x-layout>
