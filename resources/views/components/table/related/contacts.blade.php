@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'resource',
])

@php
    use App\Enums\UserPermission;

    $routeName = $resource->getTable();
    $columns = collect($data[0])
        ->except(['pivot', 'created_at', 'updated_at', 'deleted_at'])
        ->keys();

    if ($edit || $delete) {
        $columns->push('actions');
    }
@endphp


<x-modal.contact.create
    id="user-contact-create-modal"
    triggerId="user-contact-create-modal-trigger"
    :resource="$resource"
    trigger
/>

<x-table.wrapper :data="$data">
    <x-slot name="thead">
        @foreach ($columns as $column)
            <th
                class="px-6 py-3"
                scope="col"
            >
                {{ Str::ucwords(Str::replace(['_'], [' '], $column)) }}
            </th>
        @endforeach
    </x-slot>

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $row->mobile }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->landline }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->email }}
                </td>
                <td class="px-6 py-4">
                    <a
                        class="text-fg-brand font-medium hover:underline"
                        href="{{ $row->url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >{{ $row->url }}</a>
                </td>
                <td class="px-6 py-4">
                    {{ $row->info }}
                </td>
                @if ($edit || $delete)
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            @if ($edit)
                                <a
                                    class="text-brand"
                                    href="{{ route( $routeName . '.contact.edit', [$resource, $row]) }}"
                                >Edit</a>
                            @endif
                            @if ($delete && Auth::user()->id !== $row->id)
                                <x-modal.confirm.delete
                                    id="user-contact-delete-{{ $row->id }}"
                                    routeName="{{ $routeName }}.contact.destroy"
                                    :resourceId="[$resource, $row->id]"
                                    message="Are you sure you want to remove this contact?"
                                />

                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="user-contact-delete-{{ $row->id }}"
                                    data-modal-toggle="user-contact-delete-{{ $row->id }}"
                                >Delete</button>
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
