@extends('Layouts.admin')

@section('main')
    {{-- <h2>Dashboard</h2> --}}
    <div class="container p-0">
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key < 6)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key > 5 && $key < 12)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key > 11 && $key < 18)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="row-scrollable">
                <div class="row">
                    @foreach ($data['cards'] as $key => $card)
                        @if ($key > 17)
                            <div class="col">
                                <x-admin-dashboard-card2 :card="$card" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
