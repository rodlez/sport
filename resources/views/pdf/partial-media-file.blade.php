@switch($file['media_type'])
    @case('application/vnd.ms-excel')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-csv-solid.svg') }}"></td>
    @break

    @case('text/csv')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-csv-solid.svg') }}"></td>
    @break

    @case('text/plain')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-lines-solid.svg') }}"></td>
    @break

    @case('application/javascript')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/js-brands-solid.svg') }}"></td>
    @break

    @case('application/pdf')
        <td class="icons">
           <img class="icon_img" src="{{ public_path('icons/file-pdf-solid.svg') }}">
        </td>
    @break

    @case('text/html')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/html5-brands-solid.svg') }}"></td>
    @break

    @case('text/x-php')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/php-brands-solid.svg') }}"></i></td>
    @break

    @case('application/vnd.oasis.opendocument.text')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-word-solid.svg') }}"></td>
    @break

    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-word-solid.svg') }}"></td>
    @break

    @case('image/jpeg')
        <td class="icons"><img class="photo" src="{{ public_path('storage/' . $file['path']) }}"></td>
    @break

    @case('image/png')
    <td class="icons"><img class="photo" src="{{ public_path('storage/' . $file['path']) }}"></td>
    @break

    @default
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/circle-exclamation-solid.svg') }}"></td>
@endswitch
