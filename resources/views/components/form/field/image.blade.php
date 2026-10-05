@props(['name', 'identifier' => '', 'max_files' => 1])

@php
    $helper = BladeFormHelper::names($identifier, $name);
@endphp

<input
    {{ $attributes->merge([
        'name' => $name,
        'id' => $name,
        'type' => 'file',
        'class' => 'hidden',
        'accept' => 'image/*',
        'data-test' => $helper->get('testName')
    ]) }}
>
<div
    class="dropzone"
    id="image-dropzone"
></div>

@error($helper->get('errorName'))
    <p class="text-xs text-red-600">{{ $message }}</p>
@enderror

<script type="module">
    const input = document.getElementById(@js($name));
    let transfer = new DataTransfer();

    const dropzone = new Dropzone("#image-dropzone", {
        url: "#",
        autoProcessQueue: false,
        maxFiles: @js($max_files),
        maxFilesize: 5000,
        acceptedFiles: "image/*",
        resizeQuality: 1,
    });

    dropzone.on("addedfile", (file) => {
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

    // ensure only the allocated file number is allowed
    dropzone.on("maxfilesexceeded", (file) => {
        transfer = new DataTransfer();
        input.files = transfer.files;
        dropzone.removeAllFiles();
        dropzone.addFile(file);
    });
</script>
