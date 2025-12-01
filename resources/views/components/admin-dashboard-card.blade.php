<div class="card border-{{ $card['box_color'] }} mb-3 custom-dash-card">
    <div class="card-body text-light bg-{{ $card['box_color'] }} d-flex align-items-center justify-content-center">
        {{-- <img src="{{ $card['image'] }}" class="border-secondary" /> --}}
        <span class="card-text d-block text-center">
            <p class="count m-0 text-{{ $card['count_color'] }}">{{ $card['count'] }}</p>
            <p class="title m-0 text-{{ $card['count_color'] }}"><strong>{{ $card['title'] }}</strong></p>
        </span>
    </div>
    <a href="{{ $card['page_url'] }}" class="card-footer">
        <span class="text {{ $card['action_required'] && $card['count'] > 0 ? 'text-danger' : '' }}">{!!$card['action_required'] && $card['count'] > 0 ? '<strong>Action Required</strong>' : 'View Details'!!}</span>
        <span data-feather="arrow-right-circle"></span>
    </a>
</div>
