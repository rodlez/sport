<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/sports" class="font-bold text-black border-b-2 border-b-green-600">Sports</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div>

            <!-- Header -->
            <div class="flex flex-row justify-between items-center py-4 bg-green-600">
                <div>
                    <span class="text-lg text-white px-4">Entries <span id="totalin"
                            class="text-md">({{ $search != '' ? $found : $total }})</span></span>
                </div>
                <div class="px-4">
                    <a href="{{ route('sports.create') }}"
                        class="text-white text-sm sm:text-md rounded-lg py-2 px-4 bg-black hover:bg-slate-600 transition duration-1000 ease-in-out"
                        title="Create New Workout">Create</a>
                </div>
            </div>
            <!-- Filters Text-->
            <div
                class="flex flex-row justify-between items-center py-2 mx-4 mt-2 border-green-600 border-b-2 w-100 sm:w-100">
                <div>
                    <span class="px-2 text-lg text-zinc-800">Filters</span>
                </div>
                <!-- Open/Close Buttons -->
                {{-- <div>
                    @if ($showFilters % 2 != 0)
                        <a wire:click="activateFilter" class="cursor-pointer tooltip">
                            <i class="fa-solid fa-minus"></i>
                            <span class="tooltiptext">Close</span>
                        </a>
                    @else
                        <a wire:click="activateFilter" class="cursor-pointer tooltip">
                            <i class="fa-solid fa-plus"></i>
                            <span class="tooltiptext">Open</span>
                        </a>
                    @endif
                </div> --}}

                {{-- 
                // TODO: SHOW HIDE
                <div>
                    <button onclick="showHide()" id="botonini">Show</button>
                </div> --}}
            </div>
            <!-- Filters -->
            {{-- @if ($showFilters % 2 != 0) --}}
            <div id="filtrini" class="text-black bg-gray-200 rounded-lg mx-4 my-2 py-2 w-100">

                <!-- Status -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-circle-check"></i></span>
                        <span class="px-2">Status</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="pending" class="rounded-lg w-full md:w-80">
                            <option value="2">All</option>
                            <option value="0">0 - Complete</option>
                            <option value="1">1 - Pending</option>
                        </select>
                        @if ($pending != 2)
                            <a wire:click.prevent="clearFilterStatus" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Date -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2 ">

                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-violet-600 fa-lg fa-solid fa-calendar-days"></i></span>
                        <span class="px-2">Date</span>
                    </div>

                    <div class="flex flex-col justify-start items-start w-full md:w-1/2 md:text-start">
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">From</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="date" class="rounded-lg w-full" placeholder="From"
                                    wire:model.live="dateFrom">
                                @if ($initialDateFrom != $dateFrom)
                                    <a wire:click.prevent="clearFilterDate" title="Reset Filter" class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">To</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="date" class="rounded-lg w-full" placeholder="To"
                                    wire:model.live="dateTo">
                                @if ($initialDateTo != $dateTo)
                                    <a wire:click.prevent="clearFilterDate" title="Reset Filter" class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!-- Filter Error Date -->
                        <div>
                            @if ($dateTo < $dateFrom)
                                <span class="text-sm text-red-600 px-2">To must be bigger than From</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-yellow-600 fa-lg fa-solid fa-sitemap"></i></span>
                        <span class="px-2">Category (<span
                                class="font-semibold text-sm">{{ count($categories) }}</span>)</span>
                    </div>
                    <div class="flex flex-row items-center w-full md:w-1/2 md:text-start">
                        <select wire:model.live="cat" class="rounded-lg w-full md:w-80">
                            <option value="0">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['name'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                        @if ($cat > 0)
                            <a wire:click.prevent="clearFilterCategory" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Tags -->
                {{-- <div
                        class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-start gap-1 px-4 py-2">
                        <div class="w-full px-2 md:w-60 md:mx-auto md:text-start ">
                            <span><i class="text-orange-600 fa-lg fa-solid fa-tags"></i></span>
                            <span class="px-2">Tags (<span
                                    class="font-semibold text-sm">{{ count($tags) }}</span>)</span>
                        </div>
                        <div class="flex flex-row items-start w-full md:w-1/2 md:text-start">
                            <select wire:model.live="selectedTags" name="selectedTags" id="selectedTags" multiple
                                class="rounded-lg w-full md:w-80" size="6">
                                <option value="0">All</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($selectedTags != [])
                                <a wire:click.prevent="clearFilterTag" title="Reset Filter" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-red-400 px-2"><i
                                            class="fa-solid fa-circle-xmark"></i></span>
                                </a>
                            @endif
                        </div>
                    </div> --}}
                {{-- Selected tags {{var_dump($selectedTags)}} --}}
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-start gap-1 px-4 py-2">
                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start ">
                        <span><i class="text-orange-600 fa-lg fa-solid fa-tags"></i></span>
                        <span class="px-2">Tags (<span
                                class="font-semibold text-sm">{{ count($tags) }}</span>)</span>
                    </div>
                    <div class="flex flex-row items-start w-full md:w-1/2 md:text-start">
                        <div wire:ignore class="rounded-lg w-full md:w-80">
                            <select wire:model.live="selectedTags" name="selectedTags" id="selectedTags" multiple>
                                <option value="0">All</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($selectedTags != [])
                            <a wire:click="clearFilterTag" title="Reset Filter" class="cursor-pointer">
                                <span class="text-red-600 hover:text-red-400 px-2"><i
                                        class="fa-solid fa-circle-xmark"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Duration -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2 ">

                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-blue-600 fa-lg fa-solid fa-clock"></i></span>
                        <span class="px-2">Duration <span class="text-xs">(mins)</span></span>
                    </div>

                    <div class="flex flex-col justify-start items-start w-full md:w-1/2 md:text-start">
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">From</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="number" class="rounded-lg w-full" placeholder="From"
                                    wire:model.live="durationFrom">
                                @if ($initialDurationFrom != $durationFrom)
                                    <a wire:click.prevent="clearFilterDuration" title="Reset Filter"
                                        class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">To</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="number" class="rounded-lg w-full" placeholder="To"
                                    wire:model.live="durationTo">
                                @if ($initialDurationTo != $durationTo)
                                    <a wire:click.prevent="clearFilterDuration" title="Reset Filter"
                                        class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!-- Filter Error Duration -->
                        <div>
                            @if ($durationTo < $durationFrom)
                                <span class="text-sm text-red-600 px-2">To must be bigger than From</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Distance -->
                <div
                    class="flex flex-col justify-start items-start sm:flex-row sm:justify-between sm:items-center gap-1 px-4 py-2 ">

                    <div class="w-full px-2 md:w-60 md:mx-auto md:text-start">
                        <span><i class="text-emerald-600 fa-lg fa-solid fa-route"></i></span>
                        <span class="px-2">Distance <span class="text-xs">(km)</span></span>
                    </div>

                    <div class="flex flex-col justify-start items-start w-full md:w-1/2 md:text-start">
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">From</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="number" class="rounded-lg w-full" placeholder="From"
                                    wire:model.live="distanceFrom">
                                @if ($initialDistanceFrom != $distanceFrom)
                                    <a wire:click.prevent="clearFilterDistance" title="Reset Filter"
                                        class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-full md:w-80">
                            <span class="text-sm font-bold px-2">To</span>
                            <div class="flex flex-row justify-center items-center">
                                <input type="number" class="rounded-lg w-full" placeholder="To"
                                    wire:model.live="distanceTo">
                                @if ($initialDistanceTo != $distanceTo)
                                    <a wire:click.prevent="clearFilterDistance" title="Reset Filter"
                                        class="cursor-pointer">
                                        <span class="text-red-600 hover:text-red-400 px-2">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!-- Filter Error Distance -->
                        <div>
                            @if ($distanceTo < $distanceFrom)
                                <span class="text-sm text-red-600 px-2">To must be bigger than From</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reset Filters -->
                <div class="flex flex-row md:justify-end md:w-full px-4 py-2">
                    <div class="w-full md:w-1/2">
                        <button type="button"
                            class="w-full md:w-80 bg-black text-white p-2 hover:bg-slate-700 rounded-lg"
                            wire:click="clearFilters">
                            <span> Reset Filters </span>
                            <span class="px-2"><i class="fa-solid fa-delete-left"></i></span>
                        </button>
                    </div>
                </div>

            </div>
            {{-- @endif --}}

            <!-- Search -->
            <div class="flex flex-col items-start sm:justify-between sm:flex-row px-4 py-4 w-100 gap-2">
                <div class="relative w-full">
                    <div class="absolute top-2.5 bottom-0 left-4 text-slate-700">
                        <i class="fa-lg fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="search"
                        class="w-full rounded-lg pl-12 placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-green-600 border-2 border-zinc-200 placeholder:text-sm"
                        placeholder="Search by title" wire:model.live="search">
                </div>
                <!-- Pagination -->
                <div class="relative w-32">
                    <div class="absolute top-2.5 bottom-0 left-4 text-slate-700">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <select wire:model.live="perPage"
                        class="w-full rounded-lg text-end focus:outline-none focus:ring-0 focus:border-green-500 border-2 border-zinc-200 ">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <!-- Criteria -->
            @if (
                $search != '' ||
                    $pending != 2 ||
                    $initialDateTo != $dateTo ||
                    $initialDateFrom != $dateFrom ||
                    $cat > 0 ||
                    (!in_array('0', $this->selectedTags) && count($this->selectedTags) != 0) ||
                    $initialDurationTo != $durationTo ||
                    $initialDurationFrom != $durationFrom ||
                    $initialDistanceTo != $distanceTo ||
                    $initialDistanceFrom != $distanceFrom)
                <div class="flex flex-row justify-between mx-4 pb-1 border-b-2 border-b-green-600">
                    <span class="text-lg text-zinc-800 px-2">Criteria</span>
                    <a wire:click.prevent="resetAll" title="Clear All">
                        <i class="fa-solid fa-square-xmark text-red-600 hover:text-black cursor-pointer"></i>
                    </a>
                    </span>
                </div>

                <div class="flex flex-row justify-between items-center py-2 my-2 mx-4 rounded-md bg-gray-200">
                    <div class="flex flex-wrap text-xs text-white capitalize w-full p-2 gap-3 sm:gap-4">
                        <!-- Search -->
                        @if ($search != '')
                            <div class="flex relative">
                                <span
                                    class="bg-green-600 opacity-75 p-2 rounded-lg">{{ $search != '' ? 'Search' : '' }}</span>
                                <a wire:click.prevent="clearSearch" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Status -->
                        @if ($pending != 2)
                            <div class="flex relative">
                                <span
                                    class="bg-yellow-600 opacity-75 p-2 rounded-lg">{{ $pending != 2 ? 'Status (' . $pending . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterStatus" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Date -->
                        @if ($initialDateTo != $dateTo || $initialDateFrom != $dateFrom)
                            <div class="flex relative">
                                <span
                                    class="bg-violet-400 p-2 rounded-lg">{{ $initialDateTo != $dateTo || $initialDateFrom != $dateFrom ? 'Dates (' . date('d-m-Y', strtotime($dateFrom)) . ' to ' . date('d-m-Y', strtotime($dateTo)) . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterDate" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Category -->
                        @if ($cat > 0)
                            <div class="flex relative">
                                <span
                                    class="bg-yellow-600 opacity-75 p-2 rounded-lg">{{ $cat > 0 ? 'Category (' . $cat . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterCategory" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Tags -->
                        @if (!in_array('0', $this->selectedTags) && count($this->selectedTags) != 0)
                            <div class="flex relative">
                                <span
                                    class="bg-orange-600 opacity-75 p-2 rounded-lg">{{ !in_array('0', $this->selectedTags) && count($this->selectedTags) != 0 ? 'Tags (' . implode(', ', $tagNames) . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterTag" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Duration -->
                        @if ($initialDurationTo != $durationTo || $initialDurationFrom != $durationFrom)
                            <div class="flex relative">
                                <span
                                    class="bg-blue-600 opacity-75 p-2 rounded-lg">{{ $initialDurationTo != $durationTo || $initialDurationFrom != $durationFrom ? 'Duration (' . $durationFrom . ' - ' . $durationTo . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterDuration" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif
                        <!-- Distance -->
                        @if ($initialDistanceTo != $distanceTo || $initialDistanceFrom != $distanceFrom)
                            <div class="flex relative">
                                <span
                                    class="bg-emerald-600 opacity-75 p-2 rounded-lg">{{ $initialDistanceTo != $distanceTo || $initialDistanceFrom != $distanceFrom ? 'Distance (' . $distanceFrom . ' - ' . $distanceTo . ')' : '' }}</span>
                                <a wire:click.prevent="clearFilterDistance" title="Clear" class="cursor-pointer">
                                    <span class="text-red-600 hover:text-black px-2 absolute -top-2 -right-4"><i
                                            class="fa-lg fa-solid fa-circle-xmark"></i></span>
                                </a>
                            </div>
                        @endif

                    </div>

                </div>
            @endif

            <!-- Bulk Actions -->
            @if (count($selections) > 0)
                <div class="flex flex-row justify-start items-center mx-4 pt-2 pb-1 border-b-2 border-b-green-600">

                    <div class="flex flex-row items-center gap-1">
                        <span class="text-lg text-zinc-800 pl-2">Selected</span><span
                            class="text-sm">({{ count($selections) }})</span>
                    </div>

                    <div class="flex flex-row justify-between items-start w-full">

                        <div class="flex flex-row px-4 gap-2">

                            <a wire:click.prevent="bulkDelete"
                                wire:confirm="Are you sure you want to delete this entries?"
                                class="cursor-pointer text-red-600" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                            <form action="{{ route('sport.exportbulk') }}" method="POST">
                                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                @csrf
                                <input type="hidden" id="listEntriesBulk" name="listEntriesBulk"
                                    value="{{ implode(',', $selections) }}">
                                <button class="cursor-pointer text-blue-600" title="Export as Excel">
                                    <i class="fa-solid fa-file-export"></i>
                                </button>
                            </form>

                        </div>

                        <div class="flex flex-row justify-end">
                            <a wire:click.prevent="bulkClear" class="cursor-pointer" title="Unselect">
                                <i class="fa-solid fa-square-xmark text-red-600 hover:text-black cursor-pointer"></i>
                            </a>

                        </div>

                    </div>

                </div>
            @endif

            {{-- Bulk Entries {{ var_dump($selections) }} --}}

            <!-- Export -->
            <div class="flex flex-row justify-end items-end sm:flex-row sm:justify-end gap-2 pt-2 px-0 mx-4">

                <div class="flex flex-row gap-2 items-end">
                    <span class="text-xs text-gray-500 font-bold">Export to Excel </span>

                    @if ($entries->count() > 0)
                        <form action="{{ route('sport.exportselected') }}" method="POST">
                            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                            @csrf
                            <input type="hidden" id="listEntries" name="listEntries"
                                value="{{ $entries->pluck('id') }}">
                            <button
                                class="text-white text-sm sm:text-md rounded-md p-2 bg-green-600 hover:bg-green-400 transition duration-1000 ease-in-out"
                                title="Export Current Page">
                                <span class="text-xs">Page</span>
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('sport.exportall') }}"
                        class="text-white text-sm sm:text-md rounded-md p-2 bg-black hover:bg-slate-600 transition duration-1000 ease-in-out"
                        title="Export All Entries">
                        <span class="text-xs px-1">All</span>
                    </a>
                </div>

            </div>

            {{-- Entries ({{gettype($entries)}}) -> {{$entries->count()}} -> IDs ({{$entries->pluck('id')}}) --}}

            {{-- Bulk Entries Selections {{ var_dump($selections) }} selectAll -> {{var_dump($selectAll)}} --}}
            <!-- TABLE -->
            <div class="flex flex-col px-4 py-1">

                <div class="overflow-x-auto">

                    @if ($entries->count())
                        <table class="table-fixed min-w-full">
                            <thead class="h-12">
                                <tr class="text-black text-left text-sm uppercase border-t-2 border-t-green-600">
                                    <th class="p-2">
                                        <input type="checkbox" wire:model.live="selectAll"
                                            class="text-green-600 outline-none focus:ring-0 checked:bg-green-500">
                                    </th>
                                    <th wire:click="sorting('id')" scope="col"
                                        class="hover:cursor-pointer hover:text-green-600 {{ $column == 'id' ? 'text-green-600' : '' }}">
                                        <span>Id {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('title')" scope="col"
                                        class="hover:cursor-pointer  hover:text-green-600 {{ $column == 'title' ? 'text-green-600' : '' }} px-2">
                                        <span>Title {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('category_name')" scope="col"
                                        class="hover:cursor-pointer  hover:text-green-600 {{ $column == 'category_name' ? 'text-green-600' : '' }} px-2">
                                        <span>Category <span
                                                class="text-xs">{{ '(' . $differentCategories . ')' }}</span>
                                            {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('status')" title="0 - Complete, 1 - Pending"
                                        scope="col"
                                        class="hover:cursor-pointer  hover:text-green-600 {{ $column == 'status' ? 'text-green-600' : '' }} px-2 min-w-[6rem] max-w-[8rem]">
                                        P {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('location')" scope="col"
                                        class="hover:cursor-pointer  hover:text-green-600 {{ $column == 'location' ? 'text-green-600' : '' }} px-2">
                                        <span>Location <span
                                                class="text-xs">{{ '(' . $differentLocations . ')' }}</span>
                                            {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('duration')" scope="col"
                                        class="hover:cursor-pointer  hover:text-green-600 {{ $column == 'duration' ? 'text-green-600' : '' }} px-2 min-w-[8rem] max-w-[10rem]">
                                        <span>Duration min<span
                                                class="text-xs">{{ '(' . $totalDuration . ')' }}</span>
                                            {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('distance')" scope="col"
                                        class="hover:cursor-pointer  hover:text-green-600 {{ $column == 'distance' ? 'text-green-600' : '' }} px-2 min-w-[8rem] max-w-[10rem]">
                                        <span>Distance km<span class="text-xs">{{ '(' . $totalDistance . ')' }}</span>
                                            {!! $sortLink !!}</span>
                                    </th>
                                    <th wire:click="sorting('date')" scope="col"
                                        class="hover:cursor-pointer hover:text-green-600 {{ $column == 'date' ? 'text-green-600' : '' }} px-2">
                                        <span>Date {!! $sortLink !!}</span>
                                    </th>
                                    <th scope="col" class="capitalize text-left">Tags</th>
                                    <th scope="col" class="capitalize text-center">WKs</th>
                                    <th scope="col" class="capitalize text-center">Files</th>
                                    <th scope="col" class="uppercase text-center">actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($entries as $entry)
                                    <tr
                                        class="text-sm even:bg-gray-200 odd:bg-gray-300 transition-all duration-1000 hover:bg-yellow-400">
                                        <td class="px-2">
                                            <input wire:model.live="selections" type="checkbox"
                                                class="text-green-600 outline-none focus:ring-0 checked:bg-green-500"
                                                value={{ $entry->id }} id={{ $entry->id }}
                                                {{ in_array($entry->id, $selections) ? 'checked' : '' }}>
                                        </td>
                                        <td class="px-2">{{ $entry->id }}</td>
                                        <td class="cursor-pointer min-w-[10rem] max-w-[12rem] whitespace-normal leading-relaxed px-2"
                                            title="Open Workout">
                                            <a href="{{ route('sports.show', $entry) }}">
                                                {{ $entry->title }}
                                            </a>
                                        </td>
                                        <td class="px-2">{{ $entry->category_name }}</td>
                                        <td class="px-2">{!! $entry->status == 1
                                            ? '<span class="text-red-600">' . $entry->status . '</span>'
                                            : '<span class="text-green-600">' . $entry->status . '</span>' !!}</td>
                                        <td class="px-2 text-center">{{ $entry->location }}</td>
                                        <td class="px-2 text-center">{{ $entry->duration }}</td>
                                        <td class="px-2 text-center">{{ $entry->distance }}</td>
                                        <td class="px-2">{{ date('d-m-Y', strtotime($entry->date)) }}</td>
                                        <td class="text-sm text-black p-2">
                                            <div class="flex flex-col justify-between items-left gap-2">
                                                @foreach ($entry->tags as $tag)
                                                    {{ $tag->name }}
                                                @endforeach
                                            </div>
                                        </td>
                                        <td
                                            class="text-sm {{ $entry->workouts->count() > 0 ? 'text-green-600' : 'text-black' }}  p-2">
                                            {{ $entry->workouts->count() }}
                                        </td>
                                        <td class="text-sm text-black p-2">
                                            <div class="flex flex-col justify-between items-center gap-2">
                                                @foreach ($entry->files as $file)
                                                    @include('partials.mediatypes-file', [
                                                        'file' => $file,
                                                        'iconSize' => 'fa-lg',
                                                        'imagesBig' => false,
                                                    ])
                                                @endforeach
                                            </div>
                                        </td>

                                        <!-- ACTIONS-->
                                        <td class="p-2 bg-gray-100 border-b border-b-white border-l border-l-white">
                                            <div class="flex justify-center items-center gap-3">
                                                <!-- Show -->
                                                <a href="{{ route('sports.show', $entry) }}">
                                                    <span
                                                        class="text-blue-600 hover:text-black transition-all duration-500 tooltip">
                                                        <i class="fa-lg fa-solid fa-circle-info"></i>
                                                        <span class="tooltiptext">Open Entry</span>
                                                    </span>
                                                </a>
                                                <!-- PDF -->
                                                <a href="{{ route('sport_pdf.generate', $entry) }}"
                                                    title="Download as PDF">
                                                    <span
                                                        class="text-orange-600 hover:text-black transition-all duration-500 tooltip">
                                                        <i class="fa-lg fa-solid fa-file-pdf"></i>
                                                        <span class="tooltiptext">Download as PDF</span>
                                                    </span>
                                                </a>
                                                <!-- Upload File -->
                                                <a href="{{ route('sports.upload', $entry) }}">
                                                    <span
                                                        class="text-violet-600 hover:text-black transition-all duration-500 tooltip"><i
                                                            class="fa-lg fa-solid fa-file-arrow-up"></i>
                                                        <span class="tooltiptext">Upload File</span>
                                                    </span>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('sports.edit', $entry) }}" title="Edit this entry">
                                                    <span
                                                        class="text-green-600 hover:text-black transition-all duration-500"><i
                                                            class="fa-lg fa-solid fa-pen-to-square"></i></span>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('sports.destroy', $entry) }}" method="POST">
                                                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                                                    @csrf
                                                    <!-- Dirtective to Override the http method -->
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Are you sure you want to delete the entry: {{ $entry->title }}?')"
                                                        title="Delete this entry">
                                                        <span
                                                            class="text-red-600 hover:text-black transition-all duration-500"><i
                                                                class="fa-lg fa-solid fa-trash"></i></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <div
                            class="flex flex-row justify-between items-center bg-black text-white rounded-lg p-4 mx-0 sm:mx-0">
                            <span>No entries found.</span>
                            <a wire:click.prevent="resetAll" title="New Search">
                                <i
                                    class="fa-lg fa-solid fa-circle-xmark cursor-pointer px-2 text-red-600 hover:text-red-400 transition duration-1000 ease-in-out"></i>
                            </a>
                            </span>
                        </div>
                    @endif

                </div>

            </div>

            <!-- Pagination Links -->
            <div class="py-2 px-4">
                {{ $entries->links() }}
            </div>

            <!-- To the Top Button -->
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                    class="fa-solid fa-angle-up"></i></button>

            <!-- Footer -->
            <div class="flex flex-row justify-end items-center py-4 px-4 bg-green-600 sm:rounded-b-lg">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                        title="Go Back"></i>
                </a>
            </div>

        </div>


    </div>

    @script()
        <script>
            // TODO: Bind JS value and Livewire selecteTags, when the clear filters delete the array
            // must be also updated in the select2 plugin.

            $(document).ready(function() {
                $('#selectedTags').select2();
                $('#selectedTags').on('change', function(e) {
                    var data = $('#selectedTags').select2("val");

                    @this.set('selectedTags', data);
                    console.log(data);
                });

            });
        </script>
    @endscript

    {{-- <script>
        function showHide() {            

            /* let botonName = document.getElementById("botonini").innerText;

            console.log(botonName); */

        var x = document.getElementById("filtrini");  
        console.log(x.style.display);
        if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById("botonini").innerHTML = "Hide";
        } else {
        x.style.display = "none";
        document.getElementById("botonini").innerHTML = "Show";
        }
        }
        </script> --}}

</div>
