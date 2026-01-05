{{-- 
Code of colors depending on the workout level 
--}}

@switch($level_name)
    @case('Beginner')
        <span class="badge_level_begginer">{{ $level_name }}</span>
    @break

    @case('Intermediate')
    <span class="badge_level_intermediate">{{ $level_name }}</span>
    @break

    @case('Advanced')
    <span class="badge_level_advanced">{{ $level_name }}</span>
    @break
@endswitch