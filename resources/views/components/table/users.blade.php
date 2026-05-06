@props([
    'users' => [],
    'message_action' => false,
    'edit_action' => false,
    'delete_action' => false,
    'restore_action' => false,
])

<x-table
    :data="$users"
    {{ $attributes }}
>
    <x-slot:header>
        <th>Name</th>
        <th>Email</th>
        <th>Active</th>
        <th>Actions</th>
    </x-slot:header>

    @foreach ($users as $user)
        <tr>
            <td>
                <div class="flex items-end gap-1">
                    <x-bladewind.avatar
                        size="regular"
                        :image="$user->image_path && !Str::isUrl($user->image_path)
                            ? asset('storage/' . $user->image_path)
                            : $user->image_path"
                    />
                    <p><strong>{{ $user->name }}</strong></p>
                </div>
            </td>
            <td>{{ $user->email }}</td>
            <td><x-tag.active :active="$user->active" /></td>
            <td>
                <div class="flex gap-1">
                    @if ($message_action && Auth::user()->id !== $user->id)
                        <x-bladewind.button.circle
                            icon="chat-bubble-bottom-center-text"
                            color="green"
                            size="tiny"
                            outline
                            onclick="openSendMessageModal('{{ $user->name }}')"
                        />
                    @endif
                    @if ($edit_action)
                        <x-bladewind.button.circle
                            icon="pencil-square"
                            color="primary"
                            size="tiny"
                            outline
                            onclick="location.href='{{ route('users.edit', $user) }}'"
                        />
                    @endif
                    @if ($delete_action && Auth::user()->id !== $user->id)
                        <x-bladewind.button.circle
                            icon="trash"
                            color="red"
                            size="tiny"
                            outline
                            onclick="showModal('ucdm-{{ $user->id }}')"
                        />

                        <form
                            id="ucdf-{{ $user->id }}"
                            action="{{ route('users.destroy', $user) }}"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')
                        </form>

                        <x-bladewind.modal
                            name="ucdm-{{ $user->id }}"
                            type="warning"
                            ok_button_action="submitResourceDeleteForm('ucdf-{{ $user->id }}')"
                        >
                            Are you sure you want to delete this user?
                        </x-bladewind.modal>
                    @endif
                    @if ($restore_action)
                        <form
                            action="{{ route('users.restore', $user) }}"
                            method="POST"
                        >
                            @csrf

                            <x-bladewind.button.circle
                                icon="arrow-left-start-on-rectangle"
                                color="green"
                                size="tiny"
                                outline
                                can_submit
                            />
                        </form>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</x-table>
