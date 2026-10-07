@props(['files'])

<h3 class="text-lg font-bold">Gallery</h3>
<div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
    @foreach ($files as $file)
        <a
            href="{{ route('files.preview', $file) }}"
            target="_blank"
        >
            <div
                class="bg-neutral-primary-soft border-default rounded-base shadow-xs hover:bg-neutral-secondary-medium block h-72 w-72 max-w-sm border p-6">
                <section class="relative h-2/3 w-57.5">

                    @if (FileFormatType::checkMime(FileFormatType::IMAGE, $file->mime))
                        <img
                            class="contain mx-auto h-full w-auto"
                            src="{{ route('files.preview', $file) }}"
                            alt=""
                        >
                    @elseif (FileFormatType::checkMime(FileFormatType::VIDEO, $file->mime))
                        <video
                            class="mx-auto h-full w-auto"
                            autoplay
                        >
                            <source
                                src="{{ route('files.preview', $file) }}"
                                type="{{ $file->mime }}"
                            >
                        </video>
                    @else
                        <img
                            class="contain mx-auto h-full w-auto"
                            src="/image/not_found.jpeg"
                            alt="not_found_image"
                        >
                    @endif
                </section>
                <section class="p-2">
                    <p class="font-bold">{{ $file->type->label() }}</p>
                    <p class="text-sm">{{ $file->description }}</p>
                    <p class="text-sm">{{ $file->name }}</p>
                </section>
            </div>
        </a>
    @endforeach
</div>
