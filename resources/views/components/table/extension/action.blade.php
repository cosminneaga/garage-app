@props([
    'data',
    'identifier',
    'name' => 'users',
    'edit' => false,
    'delete' => false,
    'restore' => false,
    'edit_route' => null,
    'delete_route' => null,
    'restore_route' => null,
])

<td class="px-6 py-4">
    @if ($edit)
        <a
            class="text-brand"
            data-test="{{ $name }}-{{ $data->id }}-edit-button"
            href="{{ $edit_route }}"
        >Edit</a>
    @endif
    @if ($delete)
        <x-modal.confirm
            id="{{ $name }}-delete-{{ $data->id }}"
            type="delete"
            action="{{ $delete_route }}"
            message="Are you sure you want to remove {{ $name }} with identifier {{ $data[$identifier] }}?"
        />
        <button
            class="text-danger hover:cursor-pointer"
            data-modal-target="{{ $name }}-delete-{{ $data->id }}-modal"
            data-modal-toggle="{{ $name }}-delete-{{ $data->id }}-modal"
            data-test="{{ $name }}-delete-{{ $data->id }}-modal-trigger"
            type="button"
        >
            Delete
        </button>
    @endif
    @if ($restore && $data->trashed())
        <x-modal.confirm
            id="{{ $name }}-restore-{{ $data->id }}"
            type="restore"
            action="{{ $restore_route }}"
            message="Are you sure you want to restore {{ $name }} with identifier {{ $data->registration }}?"
        />
        <button
            class="text-success hover:cursor-pointer"
            data-modal-target="{{ $name }}-restore-{{ $data->id }}-modal"
            data-modal-toggle="{{ $name }}-restore-{{ $data->id }}-modal"
            data-test="{{ $name }}-restore-{{ $data->id }}-modal-trigger"
            type="button"
        >
            Restore
        </button>
    @endif
</td>
