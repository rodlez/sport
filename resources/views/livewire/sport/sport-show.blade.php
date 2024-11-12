<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/sports" class="hover:text-red-600">Sports</a> /
        <a href="/sports/{{ $sport->id }}" class="font-bold text-black border-b-2 border-b-red-600">Info</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-green-600">
            <span class="text-lg text-white px-4">Sport Info</span>
        </div>

        <!-- INFO -->
        <div class="mx-auto w-11/12 sm:w-4/5 mt-4 my-10 bg-gray-100 rounded-md shadow-sm">

            <div class="flex flex-row justify-between items-center py-4 sm:pb-8 sm:pt-0 sm:rounded-t-lg bg-black">
                <span class="text-xl text-white font-bold capitalize sm:mt-8 mx-4">Sport Information</span>
                <div class="flex flex-row justify-end items-end gap-4 w-fit sm:mt-8 mx-2">
                    <!-- PDF -->
                    {{-- <a href="{{ route('pdf.generate', $entry) }}" title="Download as PDF">
                        <i
                            class="fa-solid fa-file-pdf text-white hover:text-orange-600 transition-all duration-500"></i>
                    </a> --}}
                    <!-- Edit -->
                    <a href="{{ route('sports.edit', $sport) }}" title="Edit">
                        <i class="fa-solid fa-pencil text-white hover:text-blue-600 transition-all duration-500"></i>
                    </a>
                    <!-- Delete -->
                    <form action="{{ route('sports.destroy', $sport) }}" method="POST">
                        <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                        @csrf
                        <!-- Dirtective to Override the http method -->
                        @method('DELETE')
                        <button
                            onclick="return confirm('Are you sure you want to delete the entry: {{ $sport->title }}?')"
                            title="Delete">
                            <i
                                class="fa-solid fa-trash pr-4 text-white hover:text-red-600 transition-all duration-500"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Id -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 sm:border-t border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-fingerprint w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Id</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $sport->id }}</span>
            </div>
            <!-- User -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-circle-user w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">User</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $sport->user->name }}</span>
            </div>
            <!-- Status -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 sm:border-t border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-toggle-on w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Status</span>
                </div>
                <span
                    class="w-full px-8 sm:px-2 {{ $sport->status == 0 ? 'text-green-600' : 'text-red-600' }}">{{ $sport->status == 0 ? 'Complete' : 'Pending' }}</span>
            </div>
            <!-- Title -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <!-- Clipboard Title Button-->
                <div class="flex flex-row justify-start items-center gap-2">
                    <span x-data="{ show: false }" class="relative" data-tooltip="Copy Title">
                        <button class="btn" data-clipboard-target="#title" x-on:click="show = true"
                            x-on:mouseout="show = false" title="Copy Title">
                            <i
                                class="fa-solid fa-pen-to-square w-6 text-center text-black hover:text-blue-600 transition-all duration-500"></i>
                        </button>
                        <span x-show="show" class="absolute -top-8 -right-6">
                            <span class="bg-green-600 text-white rounded-lg p-2 opacity-100">Copied!</span>
                        </span>
                    </span>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Title</span>
                </div>
                <div id="title" class="w-full px-8 sm:px-2">{{ $sport->title }}</div>
            </div>
            <!-- Date -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-calendar-days w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Date</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $sport->date }}</span>
            </div>
            <!-- Category -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-2 sm:gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-basketball w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Category</span>
                </div>
                <div class="w-full px-8 sm:px-2">
                    <span
                        class="bg-blue-600 text-white text-sm font-bold rounded-md p-2">{{ $sport->category->name }}</span>
                </div>
            </div>
            <!-- Tags -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-2 sm:gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-tags w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Tags</span>
                </div>
                <div class="flex flex-row flex-wrap w-full px-8 sm:px-2 gap-2">
                    @foreach ($tags as $tag)
                        <span
                            class="bg-orange-600 text-white text-sm font-bold rounded-md p-2">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            <!-- Workouts Only show if the Category is also Workout -->
            @if (count($workouts) != 0)
                <div class="flex flex-col sm:flex-row py-2 px-3 gap-2 sm:gap-1 border-b border-b-gray-200">
                    <div class="flex flex-row justify-start items-center gap-2">
                        <i class="fa-solid fa-dumbbell w-6 text-center"></i>
                        <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Workouts</span>
                    </div>
                    <div class="flex flex-row flex-wrap w-full px-8 sm:px-2 gap-2">

                        @foreach ($workouts as $workout)
                            <span class="bg-red-600 text-white text-sm font-bold rounded-md p-2">
                                <a href="{{ route('workouts.show', $workout) }}">
                                    {{-- {{ excerpt($entry->title, 40) }} --}}
                                    {{ $workout->title }}
                                </a>
                            </span>
                        @endforeach

                    </div>
                </div>

                @if (count($playlist) > 0)
                <!-- Playlist, URLs of each Workout, if any -->
                <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                    <div class="flex flex-row justify-start items-center gap-2">
                        <i class="fa-brands fa-youtube w-6 text-center"></i>
                        <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Playlist</span>
                    </div>
                    <div class="flex flex-col gap-2 w-full overflow-hidden">

                        @foreach ($playlist as $video)
                            <div class="flex flex-row justify-between items-center w-full">
                                <div class="overflow-hidden w-full pl-8 pr-2 sm:px-2 text-sm">{{ $video->title }}
                                </div>
                                <div>
                                    <a href="{{ $video->url }}" target="_blank" title="Open Url">
                                        <i class="fa-solid fa-up-right-from-square px-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                @endif                

                <!-- Video Files inside the Workout -->
                @if ($totalVideos > 0)                    
                    <div class="flex flex-col py-2 px-3 gap-1 border-b border-b-gray-200">
                        <div class="flex flex-row justify-between items-center sm:items-start gap-2">
                            <div class="flex flex-row justify-start items-center gap-2">
                                <i class="fa-solid fa-video py-1 w-6 text-center"></i>
                                <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Videos ({{ $totalVideos }})</span>                            
                            </div>
                            <div class="flex flex-row">
                                <button wire:click="$set('showVideos', true)">
                                    <i class="fa-solid fa-eye px-2" title="Show"></i>
                                </button>
                            </div>
                        </div>                      
                        @if ($showVideos)
                            <div wire:transition class="text-center">
                                @foreach ($videos as $video)
                                    @foreach ($video as $value)
                                        <span class="font-bold text-sm">{{ $value['original_filename'] }}</span>
                                        <div class="aspect-video sm:pl-0 py-4">
                                            {{-- <iframe src="{{ asset('storage/' . $value['path']) }}" class="w-full h-full"
                                                frameborder="0"
                                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe> --}}
                                                <video class="w-full h-full" controls>
                                                    <source src="{{ asset('storage/' . $value['path']) }}" type="video/mp4">
                                                </video>
                                                
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif

                    </div>
                @endif

            @endif

            <!-- Location -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-location-dot w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Location</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $sport->location }}</span>
            </div>
            <!-- Duration -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-clock w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Duration</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $sport->duration }} <span class="text-xs">(mins)</span></span>
            </div>
            <!-- Distance -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center gap-2">
                    <i class="fa-solid fa-route w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Distance</span>
                </div>
                <span class="w-full px-8 sm:px-2">{{ $sport->distance }} <span class="text-xs">(km)</span></span>
            </div>
            <!-- URL -->
            @if ($sport->url != null && $sport->url != '[]')
                @foreach (json_decode($sport->url) as $key => $url)
                    <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                        <div class="flex flex-row justify-start items-center gap-2">
                            <!-- Clipboard Url Button-->
                            <span x-data="{ show: false }" class="relative" data-tooltip="Copy Url">
                                <button class="btn" data-clipboard-target="#url{{ $key }}"
                                    x-on:click="show = true" x-on:mouseout="show = false">
                                    <i
                                        class="fa-solid fa-globe w-6 text-center hover:text-blue-600 transition-all duration-500"></i>
                                </button>
                                <span x-show="show" class="absolute -top-8 -right-6">
                                    <span class="bg-green-600 text-white rounded-lg p-2 opacity-100">Copied!</span>
                                </span>
                            </span>

                            <span class="sm:text-lg font-bold sm:font-normal sm:w-24">URL <span
                                    class="text-xs">({{ $key + 1 }})</span></span>
                        </div>
                        <div class="flex flex-row justify-start items-center w-full gap-2">
                            <div id="url{{ $key }}" class="text-sm overflow-hidden w-full px-8 sm:px-2">
                                {{ $url }}
                            </div>
                            <a href="{{ $url }}" target="_blank" title="Open Url">
                                <i class="fa-solid fa-up-right-from-square px-2"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                    <div class="flex flex-row justify-start items-center gap-2">
                        <i class="fa-solid fa-globe w-6 text-center p-0"></i>
                        <span class="sm:text-lg font-bold sm:font-normal sm:w-24">URL</span>
                    </div>
                    <div class="w-full px-8 sm:px-2">-</div>
                </div>
            @endif
            <!-- Info -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1 border-b border-b-gray-200">
                <div class="flex flex-row justify-start items-center sm:items-start pb-2 gap-2">
                    <i class="fa-solid fa-circle-info py-1 w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Info</span>
                </div>
                @if (strip_tags($sport->info) != '')
                    <div class="flex relative w-full">
                        <!-- Quill Editor -->
                        <div id="quill_editor"
                            class="w-full p-2 text-md rounded-lg bg-gray-200 border border-gray-300 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-orange-500 focus:border-orange-500 ">
                            {!! $sport->info !!}
                        </div>
                        <!-- Clipboard Info Button-->
                        <span x-data="{ show: false }" class="bg-white p-1 rounded-md absolute top-1 right-2"
                            data-tooltip="Copy Info">
                            <button class="btn" data-clipboard-target="#quill_editor" x-on:click="show = true"
                                x-on:mouseout="show = false">
                                <i class="fa-regular fa-clipboard"></i>
                            </button>
                            <span x-show="show" class="absolute top-1 right-6">
                                <span class="bg-green-600 text-white rounded-lg p-1 opacity-100">Copied!</span>
                            </span>
                        </span>
                    </div>
                @else
                    <div class="w-full px-8 sm:px-2">-</div>
                @endif
            </div>

            <!-- Files -->
            <div class="flex flex-col sm:flex-row py-2 px-3 gap-1">
                <div class="flex flex-row justify-start items-center sm:items-start pb-2 gap-2">
                    <i class="fa-solid fa-file py-1 w-6 text-center"></i>
                    <span class="sm:text-lg font-bold sm:font-normal sm:w-24">Files
                        ({{ $sport->files->count() }})</span>
                </div>
                <!-- file Table -->
                <div class="w-full overflow-x-auto">
                    @if ($sport->files->count() !== 0)
                        <table class="table-auto w-full border text-sm">
                            <thead class="text-sm text-center text-white bg-black">
                                <th></th>
                                <th class="p-2 max-lg:hidden">Filename</th>
                                <th class="p-2 max-sm:hidden">Created</th>
                                <th class="p-2 max-sm:hidden">Size <span class="text-xs">(KB)</span></th>
                                <th class="p-2">Format</th>
                                <th></th>
                            </thead>

                            @foreach ($sport->files as $file)
                                <tr class="bg-white border-b text-center">
                                    <td class="p-2">
                                        @include('partials.mediatypes-file', [
                                            'file' => $file,
                                            'iconSize' => 'fa-lg',
                                            'imagesBig' => false,
                                        ])
                                    </td>
                                    <td class="p-2 max-lg:hidden">
                                        {{ $file->original_filename }}
                                    </td>
                                    <td class="p-2 max-sm:hidden">{{ $file->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="p-2 max-sm:hidden">{{ round($file->size / 1000) }} </td>
                                    <td class="p-2 ">{{ basename($file->media_type) }}</td>
                                    <td class="p-2">
                                        <div class="flex justify-center items-center gap-2">
                                            <!-- Download file -->
                                            <a href="{{ route('sportsfile.download', [$sport, $file]) }}"
                                                title="Download File">
                                                <span
                                                    class="text-green-600 hover:text-black transition-all duration-500">
                                                    <i class="fa-lg fa-solid fa-file-arrow-down"></i>
                                                </span>
                                            </a>
                                            <!-- Delete file -->
                                            <form action="{{ route('sportsfile.destroy', [$sport, $file]) }}"
                                                method="POST">
                                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                @csrf
                                                <!-- Dirtective to Override the http method -->
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Are you sure you want to delete the file: {{ $file->original_filename }}?')"
                                                    title="Delete file">
                                                    <span
                                                        class="text-red-600 hover:text-black transition-all duration-500"><i
                                                            class="fa-lg fa-solid fa-trash"></i></span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </table>
                    @endif
                    <div class="py-2">
                        @if ($sport->files->count() >= 5)
                            <span class="text-red-400 font-semibold">Max files (5) reached. Delete some to
                                upload a
                                new File.</span>
                        @else
                            <!-- Upload file -->
                            <div class="flex flex-row">
                                <a href="{{ route('sports.upload', $sport) }}"
                                    class="w-full sm:w-40 p-2 rounded-md text-white text-sm text-center bg-green-600 hover:bg-green-400 transition-all duration-500">
                                    <span> Upload File</span>
                                    <span class="px-2"><i class="fa-solid fa-file-arrow-up"></i></span>
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="bg-black py-4 sm:rounded-b-md">

            </div>


        </div>

    </div>

    <!-- To the Top Button -->
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-angle-up"></i></button>

    <!-- Footer -->
    <div class="py-4 flex flex-row justify-end items-center px-4 bg-green-600 sm:rounded-b-lg">
        <a href="{{ route('sports.index') }}">
            <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                title="Go Back"></i>
        </a>
    </div>

</div>

</div>

<script>
    new ClipboardJS('.btn');
</script>
