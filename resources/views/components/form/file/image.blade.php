@props(['name', 'identifier' => 'image'])

<div class="flex w-full items-center justify-center">
    <label
        class="bg-neutral-secondary-medium border-default-strong rounded-base hover:bg-neutral-tertiary-medium relative flex h-64 w-full cursor-pointer flex-col items-center justify-center border border-dashed"
        id="{{ $identifier . '-container' }}"
        for="{{ $identifier }}"
    >
        <div class="text-body flex flex-col items-center justify-center pb-6 pt-5">
            <x-fwb-o-upload class="mb-6 h-7 w-7" />
            <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span></p>
            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
        </div>
        <input
            class="hidden"
            type="file"
            onchange="handleImage(event, '{{ $identifier }}')"
            name="{{ $name }}"
            {{ $attributes }}
        />
    </label>
</div>
<script>
    function handleImage(event, id) {
        const file = event.target.files[0];

        const container = document.getElementById(id + "-container");

        container.querySelector("#" + id + "-field-summary")?.remove();
        container.querySelector("#" + id + "-field-img")?.remove();

        const img = document.createElement("img");
        img.id = id + "-field-img";
        img.src = URL.createObjectURL(file);
        img.className = "absolute top-0 h-full w-auto mx-auto";

        container.appendChild(img);

        const span = document.createElement("span");
        span.id = id + "-field-summary";
        span.innerText = `${(file.size / 1024 / 1024).toFixed(2)} MiB`;
        span.className = "absolute z-10 bottom-0 text-center bg-dark px-2";

        container.appendChild(span);
    }
</script>
