<div class="max-w-7xl mx-auto sm:pb-8 sm:px-6 lg:px-8">
    <!-- Sitemap -->
    <div class="flex flex-row justify-start items-start gap-1 text-sm py-3 px-4 text-slate-500">
        <a href="/wk_levels" class="text-black hover:text-violet-600">WK Levels</a> /
        <a href="/wk_levels/{{$level->id}}" class="font-bold text-black border-b-2 border-b-violet-600">Info</a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <!-- Header -->
        <div class="flex flex-row justify-between items-center py-4 bg-violet-400">
            <div>
                <span class="text-lg text-white px-4">Level Info</span>
            </div>
        </div>
        <!-- Info -->
        <div class="mx-auto w-11/12 py-4 px-2">
            <div><span class="font-semibold px-2">Name</span></div>
            <div class="flex flex-row justify-start items-center gap-4 py-2">
                <!-- Name -->
                <input type="text" id="name" class="bg-zinc-200 border border-zinc-300 text-gray-900 text-md rounded-lg w-full sm:w-1/2 pl-2 p-2  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500" value="{{ $level->name }}" disabled>
                <!-- Edit -->
                <a href="{{ route('wk_levels.edit', $level) }}">
                    <i class="fa-solid fa-pen-to-square text-green-600 hover:text-black transition duration-1000 ease-in-out" title="Edit"></i>
                </a>
                <!-- Delete -->
                <form action="{{ route('wk_levels.destroy', $level) }}" method="POST">
                    <!-- Add Token to prevent Cross-Site Request Forgery (CSRF) -->
                    @csrf
                    <!-- Dirtective to Override the http method -->
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete the level: {{ $level->name }}?')">
                        <i class="fa-solid fa-trash text-red-600 hover:text-black transition duration-1000 ease-in-out" title="Delete"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex flex-row justify-end items-center py-4 px-4 bg-violet-400 sm:rounded-b-lg">
            <a href="{{ route('wk_levels.index') }}">
                <i class="fa-lg fa-solid fa-backward-step text-white hover:text-black transition duration-1000 ease-in-out" title="Go Back"></i>
            </a>
        </div>

    </div>

</div>
