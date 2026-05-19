@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'chat' => false,
    'resource',
])

@php
    use App\Enums\UserPermission;

    $routeName = $resource->getTable();
    $columns = collect($data[0])
        ->except(['pivot', 'created_at', 'updated_at', 'deleted_at'])
        ->keys();

    if ($edit || $delete || $chat) {
        $columns->push('actions');
    }
@endphp

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
                @if ($edit || $delete || $chat)
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            @if ($chat && Auth::user()->id !== $row->id)
                                <button
                                    class="text-green-500"
                                    onclick="alert('openMessageModal')"
                                >Message</button>
                            @endif
                            @if ($edit)
                                <a
                                    class="text-brand"
                                    href="{{ route('users.edit', $row) }}"
                                >Edit</a>
                            @endif
                            @if ($delete && Auth::user()->id !== $row->id)
                                <x-modal.confirm.delete
                                    id="user-delete-{{ $row->id }}"
                                    routeName="users.destroy"
                                    resourceId="{{ $row->id }}"
                                    message="Are you sure you want to remove {{ $row->name }} from your team?"
                                />

                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="user-delete-{{ $row->id }}"
                                    data-modal-toggle="user-delete-{{ $row->id }}"
                                    type="button"
                                >Delete</button>
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>


{{-- <x-slot:header>
        <div class="flex items-center justify-between p-4">
            <h4>CONTACTS</h4>
            <x-bladewind.button onclick="showModal('modal-contact-create')">
                Add contact
            </x-bladewind.button>
        </div>
    </x-slot:header> --}}

{{-- <x-bladewind.table
        celled
        compact
    >
        <x-slot name="header">
            <th>Mobile</th>
            <th>Landline</th>
            <th>Email</th>
            <th>URL</th>
            <th>Info</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($data as $contact)
            <tr>
                <td>{{ $contact->mobile }}</td>
                <td>{{ $contact->landline }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->url }}</td>
                <td>
                    <div class="w-75">
                        {!! $contact->info !!}
                    </div>
                </td>
                <td>
                    <div class="flex gap-1">
                        @can(UserPermission::name(UserPermission::CONTACT, 'update'))
                            <a href="{{ route($routeName . '.contact.edit', [$resource, $contact]) }}">
                                <x-bladewind.button.circle
                                    icon="pencil"
                                    color="green"
                                    size="tiny"
                                    outline
                                />
                            </a>
                        @endcan
                        @can(UserPermission::name(UserPermission::CONTACT, 'delete'))
                            <x-bladewind.button.circle
                                icon="trash"
                                color="red"
                                size="tiny"
                                outline
                                onclick="showModal('cocdm-{{ $contact->id }}')"
                            />

                            <form
                                id="cocdf-{{ $contact->id }}"
                                action="{{ route($routeName . '.contact.destroy', [$resource, $contact]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                            </form>

                            <x-bladewind.modal
                                name="cocdm-{{ $contact->id }}"
                                type="warning"
                                ok_button_action="submitResourceDeleteForm('cocdf-{{ $contact->id }}')"
                            >
                                Are you sure you want to delete this contact?
                            </x-bladewind.modal>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-bladewind.table> --}}

{{-- <x-modal.contact.create
        name="modal-contact-create"
        :resource="$resource"
    /> --}}
