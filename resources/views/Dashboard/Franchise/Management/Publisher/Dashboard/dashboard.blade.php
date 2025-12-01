@extends('Layouts.Management.publisher')

@section('main')
    <h2 class="border-bottom">Dashboard</h2>
    <div class="container p-0">
        <div class="row">
            {{-- @foreach ($data['cardsdata'] as $card)
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <x-admin-dashboard-card :card="$card" />
                </div>
            @endforeach --}}
        </div>
        <div class="row">
            @foreach ($data['corporate_counts'] as $card)
                <div class="col-xxlg-2 col-xlg-2 col-lg-2 col-md-3 col-sm-4 col-6">
                    <x-admin-dashboard-card :card="$card" />
                </div>
            @endforeach
        </div>
        <div class="row">
            @foreach ($data['franchise_counts'] as $card)
                <div class="col-xxlg-2 col-xlg-2 col-lg-2 col-md-3 col-sm-4 col-6">
                    <x-admin-dashboard-card :card="$card" />
                </div>
            @endforeach
        </div>
        <div class="row">
            @foreach ($data['franchise_user_counts'] as $card)
                <div class="col-xxlg-2 col-xlg-2 col-lg-2 col-md-3 col-sm-4 col-6">
                    <x-admin-dashboard-card :card="$card" />
                </div>
            @endforeach
        </div>
        <div class="row">
            @foreach ($data['direct_user_counts'] as $card)
                <div class="col-xxlg-2 col-xlg-2 col-lg-2 col-md-3 col-sm-4 col-6">
                    <x-admin-dashboard-card :card="$card" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
