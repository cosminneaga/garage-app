@props(['name', 'identifier' => 'image'])

@php
    $helper = BladeFormHelper::names($identifier, $name);
@endphp




<input
    id="{{ $name }}"
    name="{{ $name }}"
    type="file"
    class="hidden"
    {{ $attributes }}
>
<div
    class="dropzone"
    id="image-dropzone"
></div>


<script type="module">
    const input = document.getElementById("image");

    const dropzone = new Dropzone("#image-dropzone", {
        url: "#",
        autoProcessQueue: false,
        maxFiles: 1,
        maxFilesize: 5000,
        acceptedFiles: "image/*",
        resizeQuality: 1,
    });

    dropzone.on("addedfile", (file) => {
        const transfer = new DataTransfer();
        transfer.items.add(file);
        input.files = transfer.files;

        const imageContainer = file.previewElement.querySelector(".dz-image");
        imageContainer.addEventListener("click", () => dropzone.hiddenFileInput.click());

        // Get Dropzone's progress bar
        const progressBar = file.previewElement.querySelector('.dz-upload');
        const progressContainer = file.previewElement.querySelector('.dz-progress');

        // Start at 0%
        progressBar.style.width = '0%';
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            progressBar.style.width = `${progress}%`;

            if (progress >= 100) {
                clearInterval(interval);
                progressContainer.style.display = 'none';
            }
        }, 50);
    });

    // ensure only one file is uploaded by replacing it
    dropzone.on("maxfilesexceeded", (file) => {
        dropzone.removeAllFiles();
        dropzone.addFile(file);
    });
</script>

{{-- <div class="flex w-full items-center justify-center">
    <label
        class="bg-neutral-secondary-medium border-default-strong rounded-base hover:bg-neutral-tertiary-medium relative flex h-64 w-full cursor-pointer flex-col items-center justify-center border border-dashed"
        id="{{ $identifier . '-container' }}"
        for="{{ $identifier }}"
    >

        <div class="text-body flex flex-col items-center justify-center pb-6 pt-5">
            <x-icon-o-arrow-up-tray class="mb-6 h-7 w-7" />
            <p class="mb-2 text-sm">
                <span class="font-semibold">Click to upload
                </span>
            </p>
            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
        </div>

        <input
            class="hidden"
            name="{{ $name }}"
            type="file"
            @change="handleImage(event, '{{ $identifier }}')"
            {{ $attributes }}
        >

    </label>

    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<script>
    function handleImage(event, id) {
        console.log(event, id)
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
</script> --}}
