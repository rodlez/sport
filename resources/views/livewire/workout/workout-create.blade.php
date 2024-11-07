<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">

    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/workouts" class="hover:text-red-600">Workouts</a> /
        <a href="/workouts/create" class="font-bold text-black border-b-2 border-b-red-600">Create</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-red-600">
            <span class="text-lg text-white px-4">Create a New Workout</span>
        </div>

        <!-- New Entry -->
        <form wire:submit="save">
            <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
            @csrf

            <div class="mx-auto w-11/12">
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

                <!-- Author -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Author <span class="text-red-600">*</span></h2>

                <div class="relative">
                    <input wire:model="author" name="author" id="author" type="text" value="{{ old('author') }}"
                        maxlength="200"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-circle-user bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('author')
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

                <!-- URL -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">URL</h2>

                <div class="relative">
                    <input wire:model="url" name="url" id="url" type="text" value="{{ old('url') }}"
                        maxlength="2048"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-globe bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>

                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('url')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Type -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Type <span class="text-red-600">*</span></h2>
                <div class="relative">
                    <select wire:model="type_id" name="type_id" id="type_id"
                        class="w-full pl-12 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-green-500 focus:border-green-500">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" class="text-green-600"
                                @if (old('type_id') == $type->id) selected @endif>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute flex items-center inset-y-0 left-0 pointer-events-none">
                        <i class="fa-solid fa-sitemap bg-gray-200 p-3 rounded-l-md"></i>
                    </div>
                </div>
                <div class="text-sm text-red-600 font-bold py-1 pl-12">
                    @error('type_id')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Info -->
                <h2 class="text-lg font-bold pt-2 pb-1 px-2">Info</h2>
                <div class="flex">
                    <span><i class="bg-zinc-200 p-3 rounded-l-md fa-solid fa-circle-info"></i></span>
                    <div class="w-full">
                        {{-- @livewire('quilleditor.quill') --}}
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
                <div class="py-4">
                    <button type="submit"
                        class="w-full sm:w-60 bg-black hover:bg-slate-700 text-white uppercase p-2 rounded-md shadow-none transition duration-1000 ease-in-out">
                        Save
                        <i class="fa-solid fa-floppy-disk px-2"></i>
                    </button>
                </div>

            </div>

        </form>

        <!-- To the Top Button -->
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-angle-up"></i></button>

        <!-- Footer -->
        <div class="py-4 flex flex-row justify-end items-center px-4 bg-red-600 sm:rounded-b-lg">
            <a href="{{ route('workouts.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out"
                    title="Go Back"></i>
            </a>
        </div>

    </div>

</div>