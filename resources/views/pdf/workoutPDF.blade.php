<!DOCTYPE html>
<html>

<head>
    <title>Workout Information - ID({{ $id }})</title>
    <!-- CSS, DomPDF requires using the absolute local path to the CSS file -->
    <link href="{{ public_path('css/pdfTable.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">

        <table>

            {{-- <thead> --}}
            <tr>
                <td class="tdHeader" colspan="2">Workout Information</td>
            </tr>
            {{-- </thead> --}}

            <tbody>
                <tr>
                    <td class="tdInfo">Id</td>
                    <td>{{ $id }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">User</td>
                    <td>{{ $user_name }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Title</td>
                    <td>{{ $title }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Author</td>
                    <td>{{ $author }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Date</td>
                    <td>{{ $date }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Duration</td>
                    <td>{{ $duration }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Type</td>
                    <td><span class="badge_type">{{ $type_name }}</span></td>
                </tr>
                <tr>
                    <td class="tdInfo">Level</td>
                    <td>@include('pdf.partial-workout-levels', ['level_name' => $level_name])</td>
                </tr>
                @if (isset($url))
                    <tr>
                        <td class="tdInfo">URL</td>
                        <td>{!! $url !!}</td>
                    </tr>
                @else
                    <tr>
                        <td class="tdInfo">URL</td>
                        <td>-</td>
                    </tr>
                @endif
                @if (isset($description))
                    <tr>
                        <td class="tdInfo">Description</td>
                        <td>{!! $description !!}</td>
                    </tr>
                @else
                    <tr>
                        <td class="tdInfo">Description</td>
                        <td>-</td>
                    </tr>
                @endif

            </tbody>

        </table>

        @if (isset($files))

        <div class="page_break">            
        </div>

        <div class="page_break">

            <table>
                <tr>
                    <td class="tdInfo">Files</td>
                </tr>
                @foreach ($files as $file)
                    <tr>
                        @include('pdf.partial-media-file', $file)
                    </tr>
                @endforeach
            </table>

        </div>

        @endif


    </div>

</body>

</html>
