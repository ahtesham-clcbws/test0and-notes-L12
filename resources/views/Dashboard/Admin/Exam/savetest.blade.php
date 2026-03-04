<?php if(isset($data['test']) && isset($data['test']['package']))  $package = $data['test']['package']; else $package = 0; ?>
@extends('Layouts.admin',['package' => $package])

@section('css')
    <style>
        .dashboard-container .alertx {
            position: relative;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            min-height: 49px;
        }

        .dashboard-container .form-switch {
            padding-top: 4px;
        }

        .dashboard-container .form-switch label {
            width: -webkit-fill-available;
        }

        .noDisplay {
            display: none;
        }
    </style>
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            @livewire('admin.tests.test-form', ['testId' => $data['test']->id ?? null])
        </div>
    </div>

    @if($data['test'] && $data['test']->id)
    <div class="row mt-4">
        <div class="col-12">
            <h4 class="mb-3 px-3">Manage Test Sections</h4>
            @livewire('admin.tests.test-section-manager', ['testId' => $data['test']->id])
        </div>
    </div>
    @endif
@endsection

@section('javascript')
    {{-- Livewire handles most logic now --}}
@endsection
