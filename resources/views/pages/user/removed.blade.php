<x-layout title="Removed">
    <h1 class="text-2xl font-bold underline">REMOVED TEAM MEMBERS</h1>
    <br><br>

    <x-table :data="$users">
        <x-slot:header>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>Actions</th>
        </x-slot:header>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    <a
                        class="underline"
                        href="{{ route('users.show', $user) }}"
                    >{{ $user->email }}</a>
                </td>
                <td><x-active-tag :active="$user->active" /></td>
                <td class="flex gap-1">
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

    <!-- DELETE USER FORM -->
    <form
        id="form-delete-user"
        method="POST"
    >
        @csrf
        @method('DELETE')
    </form>
</x-layout>

<script>
    sendMessage = (name) => {
        showModal('send-message');
        domEl('.bw-send-message .modal-title').innerText =
            `Send Message to ${name}`;
    }

    const goToEditUser = (id) => {
        location.href = `/users/${id}/edit`;
    }

    const deleteUser = (id) => {
        // temporary fix!!!
        // TODO: manipulate a form to submit this information as redirect does not work

        axios.delete(`/users/${id}`)
            .then(res => location.href = "/users")
            .catch(err => location.href = "/users");
    };
</script>
