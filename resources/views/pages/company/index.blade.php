<x-layout>
    <ul class="list-decimal!">
        @foreach ($companies as $company)
            <li><a
                    href="{{ route('companies.show', $company) }}"
                    rel="noopener noreferrer"
                >{{ $company->name }}</a></li>
        @endforeach
    </ul>
</x-layout>
