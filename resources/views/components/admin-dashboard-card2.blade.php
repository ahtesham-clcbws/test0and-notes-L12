<div class="card custom-dash-card" style="border-color:{{ $card['border-color'] }}">
    <div class="part1" style="background-color:{{ $card['background-color'] }}">
        <div class="img_area" style="border-color:{{ $card['border-color'] }}">
            <img class="box_icon" src="{{ asset($card['icon']) }}">
        </div>
        <div class="head_area">
            <div class="number" style="color:{{ $card['color'] }}">{{ $card['count'] }}</div>
            <div class="num_heading">{{ $card['title'] }}</div>
        </div>
    </div>
    <div class="part2"style="border-top-color:{{ $card['border-color'] }}">
        <div class="box_heading">
            <a href="{{ $card['page_url'] }}" style="color:{{ $card['color'] }}">
                {{ $card['count'] > 0 ? 'Action Required!' : 'View Details' }}
                {{-- <span data-feather="arrow-right-circle-fill"></span> --}}
                <i class="bi bi-arrow-right-circle icon_img"></i>
            </a>
        </div>
    </div>
</div>
