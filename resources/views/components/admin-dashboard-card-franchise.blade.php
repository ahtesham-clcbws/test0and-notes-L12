<div class="card franchise-card custom-dash-card">
    <div class="part1">
        <div class="img_area">
            <img class="box_icon" src="{{ asset($card['icon']) }}">
        </div>
        <div class="head_area">
            <div class="number">{{ $card['count'] }}</div>
            <div class="num_heading">{{ $card['title'] }}</div>
        </div>
    </div>
    <div class="part2">
        <div class="box_heading {{ $card['count'] > 0 ? 'action_required' : '' }}">
            <a href="{{ $card['page_url'] }}">
                {{ $card['count'] > 0 ? 'Action Required!' : 'View Details' }}
                {{-- <span data-feather="arrow-right-circle-fill"></span> --}}
                <i class="bi bi-arrow-right-circle icon_img"></i>
            </a>
        </div>
    </div>
</div>
