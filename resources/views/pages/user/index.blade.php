<?php
$actions = ["icon:chat-bubble-bottom-center-text | tip:send message | color:green | click:sendMessage('{name}')", "icon:pencil-square | tip:edit | color:yellow | click:goToEditUser('{id}')", "icon:trash | tip:delete | color:red | click:deleteUser('{id}')"];
?>

<x-layout title="Team">
    <h1 class="text-2xl font-bold underline">MY TEAM</h1>
    <br><br>
    <x-bladewind.card class="text-black">
        <x-bladewind.table
            celled
            paginated
            page_size="10"
            divider="thin"
            has_border
            has_hover="false"
            :data="$users"
            exclude_columns="email_verified_at, deleted_at, created_at, updated_at, pivot"
            :action_icons="$actions"
        />
    </x-bladewind.card>


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
