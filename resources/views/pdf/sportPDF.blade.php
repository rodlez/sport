<!DOCTYPE html>
<html>

<head>
    <title>Sport Information - ID({{ $id }})</title>
    <!-- CSS, DomPDF requires using the absolute local path to the CSS file -->
    <link href="{{ public_path('css/pdfTable.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">

        <table>

            {{-- <thead> --}}
            <tr>
                <td class="tdHeader" colspan="2">Sport Information</td>
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
                    <td class="tdInfo">Status</td>
                    <td>{{ $status }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Title</td>
                    <td>{{ $title }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Date</td>
                    <td>{{ $date }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Category</td>
                    <td><span class="badge_category">{{ $category_name }}</span></td>
                </tr>
                <tr>
                    <td class="tdInfo">Tags</td>
                    <td>
                        @foreach ($tags as $tag)
                            <span class="badge_tag">{{ $tag['name'] }}</span>
                        @endforeach
                    </td>
                </tr>
                @if (isset($workouts))
                    <tr>
                        <td class="tdInfo">Workouts</td>
                        <td class="tdWorkout">
                            @foreach ($workouts as $workout)
                                <span class="badge_workout">{{ $workout['title'] }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="tdInfo">Location</td>
                    <td>{{ $location }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Duration</td>
                    <td>{{ $duration }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Distance</td>
                    <td>{{ $distance }}</td>
                </tr>


                @if (isset($urls))
                    <tr>
                        <td class="tdInfo">Urls</td>
                        <td>
                            @foreach ($urls as $url)
                                <span class="url">{{ $url }}</span>
                            @endforeach
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="tdInfo">Url</td>
                        <td>-</td>
                    </tr>
                @endif
                @if (isset($info))
                    <tr>
                        <td class="tdInfo">Info</td>
                        <td>{!! $info !!}</td>
                    </tr>
                @else
                    <tr>
                        <td class="tdInfo">Info</td>
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
