@props([
    'users' => [],
    'message_action' => false,
    'edit_action' => false,
    'delete_action' => false,
    'restore_action' => false,
])

@php
    use App\Enums\UserPermission;
@endphp

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
                    @if ($message_action)
                        @if (Auth::user()->id !== $user->id)
                            <x-bladewind.button.circle
                                icon="chat-bubble-bottom-center-text"
                                color="green"
                                size="tiny"
                                outline
                                onclick="sendMessage('{{ $user->name }}')"
                            />
                        @endif
                    @endif
                    @if ($edit_action)
                        @can(UserPermission::name(UserPermission::USER, 'store'))
                            <x-bladewind.button.circle
                                icon="pencil-square"
                                color="primary"
                                size="tiny"
                                outline
                                onclick="location.href='/users/{{ $user->id }}/edit'"
                            />
                        @endcan
                    @endif
                    @if ($delete_action && Auth::user()->id !== $user->id)
                        @can(UserPermission::name(UserPermission::USER, 'delete'))
                            <form
                                id="form-delete-user"
                                action="{{ route('users.destroy', $user) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <x-bladewind.button.circle
                                    icon="trash"
                                    color="red"
                                    size="tiny"
                                    outline
                                    can_submit
                                    onclick="return confirm('Are you sure?')"
                                />
                            </form>
                        @endcan
                    @endif
                    @if ($restore_action)
                        @can(UserPermission::name(UserPermission::USER, 'restore'))
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
                </div>
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
        domEl('.bw-send-message .modal-title').innerText = `Send Message to ${name}`;
    }
</script>
