@switch($file->media_type)
    @case('video/mp4')
        <td class="py-2">
            <a href="{{ asset('storage/' . $file->path) }}" title="Open Video" target="_blank">
                <i class="fa-3x fa-solid fa-file-video"></i>
            </a>
        </td>
    @break

    @case('text/plain')
        <td class="py-2"><i class="fa-2x fa-regular fa-file-lines"></i></td>
    @break

    @case('application/pdf')
        <td class="py-2">
            <a href="{{ asset('storage/' . $file->path) }}" title="Open PDF">
                <i class="fa-2x fa-regular fa-file-pdf"></i>
            </a>
        </td>
    @break

    @case('application/vnd.oasis.opendocument.text')
        <td class="py-2"><i class="fa-2x fa-regular fa-file-word"></i></td>
    @break

    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
        <td class="py-2"><i class="fa-2x fa-regular fa-file-word"></i></td>
    @break

    @case('image/jpeg')
        <td class="py-2">
            <a href="{{ asset('storage/' . $file->path) }}" title="Open Image">
                <img src="{{ asset('storage/' . $file->path) }}" class="w-12 md:w-24 mx-auto rounded-lg">
            </a>
        </td>
    @break

    @case('image/png')
        <td class="py-2">
            <a href="{{ asset('storage/' . $file->path) }}" title="Open Image">
                <img src="{{ asset('storage/' . $file->path) }}" class="w-12 md:w-24 mx-auto rounded-lg">
            </a>
        </td>
    @break

    @default
        <td class="py-2"><i class="fa-2x fa-solid fa-triangle-exclamation text-red-600 hover:text-red-400"
                title="Not a valid Format"></i></td>
@endswitch
