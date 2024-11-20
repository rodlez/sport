<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/sports" class="hover:text-green-600">Sports</a> /
        <a href="/sports/create" class="font-bold text-black border-b-2 border-b-green-600">Create</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-green-600">
            <span class="text-lg text-white px-4">Create a New Sport</span>
        </div>

        <!-- New Entry -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <div class="mx-auto w-11/12">
                <!-- Status -->
                <div
                    class="flex flex-row justify-start items-center mt-6 py-2 px-2 rounded-md gap-3 {{ $status == 0 ? 'bg-green-100' : 'bg-red-100' }}  ">
                    <div>
                        <h2 class="text-black text-lg font-semibold">Pending</h2>
                    </div>
                    <div>
                        <label class="inline-flex cursor-pointer pt-2">
                            <input wire:model.live="status" name="status" id="status" type="checkbox"
                                value="{{ old('status') }}" class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-white dark:peer-focus:ring-gray-600 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Title <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="title" name="title" id="title" type="text" value="{{ old('title') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-pen-to-square  bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('title')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Date -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Date <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="date" name="date" id="date" type="date" value="{{ old('date') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-calendar-days  bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('date')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Category -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Category <span class="text-red-600">*</span></h2>
                <div class="relative">
                    <select wire:model.live="category_id" name="category_id" id="category_id"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" class="text-green-600"
                                @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-basketball bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('category_id')
                        {{ $message }}
                    @enderror
                </div>

                <div class="{{($category_id == 12) ? '' : 'hidden'}}">
                    <!-- Workouts -->
                    <h2 class="text-lg font-bold pt-2 pb-1 px-2">Workouts<span class="text-red-600">*</span></h2>

                    <div class="flex flex-row">

                        <div class="flex items-start inset-y-0 left-0 pointer-events-none">
                            <i class="fa-solid fa-dumbbell bg-gray-200 p-3 rounded-l-md"></i>
                        </div>

                        <div wire:ignore class="w-full">
                            <select wire:model="selectedWorkouts" name="selectedWorkouts" id="selectedWorkouts"
                                multiple>
                                @foreach ($workouts as $workout)
                                    <option value="{{ $workout->id }}"
                                        @if (old('selectedWorkouts') == $workout->id) selected @endif>
                                        {{ $workout->title }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>
                <!-- Tags -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Tags <span class="text-red-600">*</span></h2>

                <div class="flex flex-row">

                    <div class="flex items-start inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-tags bg-gray-200 p-3 rounded-l-md"></i>
                    </div>

                    <div wire:ignore class="w-full">
                        <select wire:model="selectedTags" name="selectedTags" id="selectedTags" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" @if (old('selectedTags') == $tag->id) selected @endif>
                                    {{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('selectedTags')
                        {{ $message }}
                    @enderror
                </div>               

                <!-- Location -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Location <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="location" name="location" id="location" type="text"
                        value="{{ old('location') }}" maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-location-dot bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('location')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Duration -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Duration <span class="text-xs">(mins)</span> <span
                        class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="duration" name="duration" id="duration" type="number" step="1"
                        value="{{ old('duration') }}" maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">

                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-clock bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('duration')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Distance -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Distance <span class="text-xs">(km)</span></h2>

                <div class="relative">
                    <input wire:model="distance" name="distance" id="distance" type="number" step="0.1"
                        value="{{ old('distance') }}" maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">

                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-route bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('distance')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Url -->
                <div class="flex flex-row justify-start items-center gap-0">
                    <h2 class="text-lg font-bold pt-2 pb-1 px-2">URLs</h2>
                    @if ($inputs->count() < 5)
                        <button type="button" wire:click="add">
                            <i class="text-green-600 hover:text-green-400 transition duration-500 ease-in-out fa-solid fa-circle-plus"
                                title="Add Url"></i>
                        </button>
                    @else
                        <span class="text-sm text-red-600 font-bold pt-1">You have reached the limit of Urls (5)</span>
                    @endif
                </div>
                @php $count = 0 @endphp
                @foreach ($inputs as $key => $value)
                    <div class="relative pb-2">
                        <input wire:model.live="inputs.{{ $key }}.url" id="inputs.{{ $key }}.url"
                            type="text" value="{{ old('url') }}" maxlength="2047"
                            class="w-full px-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                        @if ($count > 0)
                            <div class="absolute flex items-center inset-y-0 -top-2 right-0">
                                <button type="button" wire:click="remove({{ $key }})" title="Delete">
                                    <i
                                        class="fa-solid fa-trash bg-gray-200 p-3 rounded-r-md text-red-600 hover:text-red-400 transition duration-500 ease-in-out "></i></span>
                                </button>
                            </div>
                        @endif
                        <div class="absolute flex items-center inset-y-0 -top-2 left-0 pointer-events-none">
                            <i class="fa-solid fa-globe bg-gray-200 p-3 rounded-l-md"></i>
                        </div>
                    </div>
                    <div class="text-sm text-red-600 font-bold px-14">
                        @error('inputs.' . $key . '.url')
                            {{ $message }}
                        @enderror
                    </div>
                    @php $count++ @endphp
                @endforeach

                <!-- Info -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Info</h2>
                <div class="flex">
                    <span><i class="bg-zinc-200 p-3 rounded-l-md fa-solid fa-circle-info"></i></span>
                    <div class="w-full">
                        @livewire('texteditor.quill')
                        {{-- <livewire:quilleditor.quill /> --}}
                    </div>
                </div>
                <!-- Errors -->
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('info')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Save -->
                <div class="py-4 sm:pl-10">
                    <button type="submit"
                        class="w-full sm:w-60 bg-black hover:bg-slate-700 text-white uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out">
                        Save
                        <i class="fa-solid fa-floppy-disk px-2"></i>
                    </button>
                </div>

            </div>

        </form>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i
                class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="py-4 flex flex-row justify-end items-center px-4 bg-green-600 sm:rounded-b-lg">
            <a href="{{ route('sports.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                    title="Go Back"></i>
            </a>
        </div>

        @script()
            <script>
                $(document).ready(function() {
                    $('#selectedTags').select2();

                    // event
                    $('#selectedTags').on('change', function() {
                        let selected = $(this).val();
                        //console.log(selected);
                        //$wire.set('selectedTags', selected); -> equivalent to model.live, makes a request for each selection
                        //$wire.set('selectedTags', selected, false);     // only update when click, equivalent to model
                        $wire.selectedTags = selected; // same as $wire.set('selectedTags', selected, false);
                    });

                });

                $(document).ready(function() {
                    $('#selectedWorkouts').select2();

                    // event
                    $('#selectedWorkouts').on('change', function() {
                        let selected = $(this).val();
                        //console.log(selected);
                        //$wire.set('selectedWorkouts', selected); -> equivalent to model.live, makes a request for each selection
                        //$wire.set('selectedWorkouts', selected, false);     // only update when click, equivalent to model
                        $wire.selectedWorkouts =
                        selected; // same as $wire.set('selectedWorkouts', selected, false);
                    });

                });
            </script>
        @endscript

    </div>

</div>
