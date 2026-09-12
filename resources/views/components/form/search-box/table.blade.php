@props([
    'action' => route('users.index'),
    'id' => 'search-form-box',
    'method' => 'GET',
])

<form
    class="flex items-center gap-2"
    method="{{ $method }}"
    action="{{ $action }}"
>
    @foreach (request()->except('search') as $key => $value)
        <x-form.field.text
            name="{{ $key }}"
            value="{{ $value }}"
            hidden
        />
    @endforeach

    <x-form.field.search
        name="search"
        value="{{ request('search') }}"
    />
</form>
