<?php
$actions = [
    [
        'icon' => 'chat-bubble-bottom-center-text',
        'tip' => 'send message',
        'color' => 'green',
        'icon_type' => 'solid', // default is outline
        'button_outline' => false,
        'click' => "sendMessage('{name}')",
    ],
    [
        'icon' => 'pencil-square',
        'click' => "redirect('/users/{id}')",
    ],
    [
        'icon' => 'trash',
        'color' => 'red',
        'click' => "deleteUser({id}, '{name}')",
    ],
];
?>

<x-layout>
    <x-bladewind.table
        celled
        divider="thin"
        has_border
        has_hover="false"
    >
        <x-slot name="header">
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->active }}</td>
                <td class="flex gap-1">
                    <x-bladewind.button.circle
                        icon="chat-bubble-bottom-center-text"
                        color="green"
                        size="tiny"
                        outline
                        onclick="sendMessage('{{ $user->name }}')"
                    />
                    <x-bladewind.button.circle
                        icon="pencil-square"
                        color="primary"
                        size="tiny"
                        outline
                        onclick="location.href='/users/{{ $user->id }}/edit'"
                    />
                    <form
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
                        />
                    </form>
                </td>
            </tr>
        @endforeach
    </x-bladewind.table>


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
</x-layout>

<script>
    sendMessage = (name) => {
        showModal('send-message');
        domEl('.bw-send-message .modal-title').innerText =
            `Send Message to ${name}`;
    }
</script>
