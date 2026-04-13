@props([
    'users' => [],
    'message_action' => false,
    'edit_action' => false,
    'delete_action' => false,
    'restore_action' => false,
])

<x-table :data="$users" {{ $attributes }}>
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
                        :image="$user->image_path &&
                        !Str::isUrl($user->image_path)
                            ? asset('storage/' . $user->image_path)
                            : $user->image_path"
                    />
                    <p><strong>{{ $user->name }}</strong></p>
                </div>
            </td>
            <td>
                <a
                    class="underline"
                    href="{{ route('users.show', $user) }}"
                >{{ $user->email }}</a>
            </td>
            <td>
                <x-active-tag :active="$user->active" />
            </td>
            <td class="flex gap-1">
                @if ($message_action)
                    <x-bladewind.button.circle
                        icon="chat-bubble-bottom-center-text"
                        color="green"
                        size="tiny"
                        outline
                        onclick="sendMessage('{{ $user->name }}')"
                    />
                @endif
                @if ($edit_action)
                    @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER,
                        'store'))
                        <x-bladewind.button.circle
                            icon="pencil-square"
                            color="primary"
                            size="tiny"
                            outline
                            onclick="location.href='/users/{{ $user->id }}/edit'"
                        />
                    @endcan
                @endif
                @if ($delete_action)
                    @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER,
                        'delete'))
                        <form
                            action="{{ route('users.destroy', $user) }}"
                            method="POST"
                            id="form-delete-user"
                        >
                            @csrf
                            @method('DELETE')

                            <x-bladewind.button.circle
                                icon="trash"
                                color="red"
                                size="tiny"
                                outline
                                can_submit
                            />
                        </form>
                    @endcan
                @endif
                @if ($restore_action)
                    @can(\App\Enums\UserPermission::name(\App\Enums\UserPermission::USER,
                        'restore'))
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
                    @endcan
                @endif
            </td>
        </tr>
    @endforeach
</x-table>

<!-- MODAL AREA -->
<x-bladewind.modal
    name="send-message"
    title=""
>
    <div class="mb-6">
        The message will be delivered to their company
        inbox if they are not currently online
    </div>
    <x-bladewind.textarea
        placeholder="Type message here..."
        rows="5"
    />
</x-bladewind.modal>

<script>
    sendMessage = (name) => {
        showModal('send-message');
        domEl('.bw-send-message .modal-title').innerText =
            `Send Message to ${name}`;
    }
</script>
