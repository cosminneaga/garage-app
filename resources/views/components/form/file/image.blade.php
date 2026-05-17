@props([ 'name', 'test' ])

<div class="flex w-full items-center justify-center">
    <label
        class="bg-neutral-secondary-medium border-default-strong rounded-base hover:bg-neutral-tertiary-medium relative flex h-64 w-full cursor-pointer flex-col items-center justify-center border border-dashed"
        id="image-container"
        for="{{ $name }}"
    >
        <div class="text-body flex flex-col items-center justify-center pb-6 pt-5">
            <x-fwb-o-upload class="mb-6 h-7 w-7" />
            <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span></p>
            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
        </div>
        <input
            class="hidden"
            id="{{ $name }}"
            name="{{ $name }}"
            data-test="{{ $test }}"
            type="file"
            {{ $attributes }}
            onchange="handleImage(event)"
        />
    </label>
</div>
<script>
    function handleImage(event) {
        const file = event.target.files[0];
        const container = document.getElementById("image-container");

        document.getElementById("image-field-summary")?.remove();
        document.getElementById("image-field-img")?.remove();

        const img = document.createElement("img");
        img.id = "image-field-img";
        img.src = URL.createObjectURL(file);
        img.className = "absolute top-0 h-full w-auto mx-auto";
        container.appendChild(img);

        const span = document.createElement("span");
        span.id = "image-field-summary";
        span.innerText = `${parseFloat(file.size / 1000 / 1000).toFixed(2)} MiB`;
        span.className = "absolute z-10 bottom-0 text-center";
        container.appendChild(span);
    }
</script>
