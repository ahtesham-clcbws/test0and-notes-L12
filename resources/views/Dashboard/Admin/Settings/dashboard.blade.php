@extends('Layouts.admin')

@section('main')
    {{-- <h2 class="border-bottom">Dashboard</h2> --}}
    <div class="container p-0">
        <div class="row">
            @foreach ($boxes as $key => $boxCategory)
                <h3 class="mt-3 border-bottom">{{ Str::ucfirst($key) }}</h3>
                <div class="accordion p-0" id="{{ $key }}_accordian">
                    @foreach ($boxCategory as $boxKey => $box)
                   
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $key }}_{{ $boxKey }}" aria-expanded="false"
                                    aria-controls="{{ $key }}_{{ $boxKey }}">
                                    {{ $box['title'] }}&nbsp;&nbsp;<small><b>({{ $box['namekey'] }})</b></small>
                                </button>
                            </h2>
                            <div id="{{ $key }}_{{ $boxKey }}" class="accordion-collapse collapse"
                                aria-labelledby="headingTwo" data-bs-parent="#{{ $key }}_accordian">
                                <div class="accordion-body">
                                    <form class="row g-3" method="POST" action="">
                                        @csrf
                                        <input type="number" name="id" style="display: none;" value="{{ $box['id'] }}">
                                        <div class="col-md-6">
                                            <label for="{{ $box['namekey'] }}box_color" class="form-label">Box
                                                Color</label>
                                                <select id="{{ $box['namekey'] }}box_color" class="form-select select2color" name="box_color" required>
                                                    <option value="primary" {{ isset($box['box_color']) && $box['box_color'] == 'primary' ? 'selected' : '' }}>Primary</option>
                                                    <option value="secondary" {{ isset($box['box_color']) && $box['box_color'] == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                    <option value="success" {{ isset($box['box_color']) && $box['box_color'] == 'success' ? 'selected' : '' }}>Success</option>
                                                    <option value="danger" {{ isset($box['box_color']) && $box['box_color'] == 'danger' ? 'selected' : '' }}>Danger</option>
                                                    <option value="warning" {{ isset($box['box_color']) && $box['box_color'] == 'warning' ? 'selected' : '' }}>Warning</option>
                                                    <option value="info" {{ isset($box['box_color']) && $box['box_color'] == 'info' ? 'selected' : '' }}>Info</option>
                                                </select>
                                                
                                        </div>
                                        <div class="col-md-6">
                                            <label for="{{ $box['namekey'] }}count_color" class="form-label">Text
                                                Color</label>
                                                @php
                                                $selectedColor = $box['count_color'] ?? 'dark'; // Default to 'dark' if 'count_color' is not set
                                            @endphp
                                            
                                            <select id="{{ $box['namekey'] }}count_color" class="form-select select2color" name="count_color" required>
                                                <option value="dark" {{ $selectedColor == 'dark' ? 'selected' : '' }}>Dark</option>
                                                <option value="light" {{ $selectedColor == 'light' ? 'selected' : '' }}>Light</option>
                                                <option value="primary" {{ $selectedColor == 'primary' ? 'selected' : '' }}>Primary</option>
                                                <option value="secondary" {{ $selectedColor == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                                <option value="success" {{ $selectedColor == 'success' ? 'selected' : '' }}>Success</option>
                                                <option value="danger" {{ $selectedColor == 'danger' ? 'selected' : '' }}>Danger</option>
                                                <option value="warning" {{ $selectedColor == 'warning' ? 'selected' : '' }}>Warning</option>
                                                <option value="info" {{ $selectedColor == 'info' ? 'selected' : '' }}>Info</option>
                                            </select>
                                            
                                        </div>
                                        <div class="col-12">
                                            <label for="{{ $box['namekey'] }}title" class="form-label">Reference
                                                Text</label>
                                            <input type="text" class="form-control" id="{{ $box['namekey'] }}title"
                                                name="title" value="{{ $box['title'] }}" required>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection


@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <style>
        .select2Image {
            border-radius: 50%;
            border: solid;
            max-height: 22px;
        }

        /* .select2-selection__arrow {
            display: none;
        }

        .select2-selection--single {
            border: 0;
        } */

    </style>
@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').each(function() {
            $(this).addClass('form-select');
        })

        function formatState(state) {
            // console.log(state)
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "/images/noimage.png";
            var $state = $(
                '<span><img class="select2Image bg-' + state.element.value + '" src="' + baseUrl + '"/> ' + state.text +
                '</span>'
            );
            return $state;
        }

        function formatState2(state) {
            if (!state.id) {
                return state.text;
            }

            var baseUrl = "/images/noimage.png";
            var $state = $(
                '<span><img class="select2Image bg-' + state.element.value + '" src="' + baseUrl + '" /> ' + state
                .text + '</span>'
            );

            // Use .text() instead of HTML string concatenation to avoid script injection issues
            $state.find("span").text(state.text);
            $state.find("img").attr("src", baseUrl);

            return $state;
        };
        $('.select2color').select2({
            theme: 'bootstrap4',
            templateResult: formatState,
            templateSelection: formatState2
        });
    </script>
@endsection
