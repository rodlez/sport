{{-- 
Code of colors depending on the workout level 
--}}

@switch($level)
    @case('Beginner')
        <span class="text-green-600">{{ $level }}</span>
    @break

    @case('Intermediate')
        <span class="text-yellow-600">{{ $level }}</span>
    @break

    @case('Advanced')
        <span class="text-red-600">{{ $level }}</span>
    @break
@endswitch
