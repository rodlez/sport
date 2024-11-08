<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/wk_levels" class="hover:text-violet-600">WK Levels</a> /
        <a href="/wk_levels/{{$level->id}}" class="hover:text-violet-600">Info</a> /
        <a href="/wk_levels/edit/{{ $level->id }}" class="font-bold text-black border-b-2 border-b-violet-600">Edit</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-violet-400">
            <div>
                <span class="text-lg text-white px-4">Level Edit</span>
            </div>
        </div>
        <!--Level -->
        <div class="mx-auto w-11/12 py-4 px-2">
            <form action="{{ route('wk_levels.update', $level) }}" method="POST">
                <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                @csrf
                <!-- Dirtective to Override the http method -->
                @method('PUT')

                <div class="flex flex-col justify-start items-start w-full sm:w-2/3 gap-4 py-2">
                    <span class="text-md font-semibold px-2">Name</span>
                    <input name="name" id="name" type="text" value="{{ $level->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg w-full sm:w-2/3 p-2 focus:ring-violet-500 focus:border-violet-500">
                </div>
                <!-- Errors -->
                @error('name')
                    <div>
                        <span class="text-sm text-red-400 font-bold px-2">{{ $message }}</span>
                    </div>
                @enderror
                <!-- Save -->
                <div class="py-4">
                    <button type="submit" class="w-full sm:w-fit bg-black hover:bg-slate-700 text-white capitalize p-2 sm:px-4 rounded-lg shadow-none transition duration-500 ease-in-out">
                        Save
                        <i class="fa-solid fa-floppy-disk px-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <div class="flex flex-row justify-end items-center py-4 px-4 bg-violet-400 sm:rounded-b-lg">
        <a href="{{ route('wk_levels.show', $level) }}">
            <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out" title="Go Back"></i>
        </a>
    </div>
</div>