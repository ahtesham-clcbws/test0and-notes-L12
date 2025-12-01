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
    <div class="container p-0">
        <form class="card dashboard-container mb-5" action="{{ route('administrator.manage_test_cat_process') }}"" method="post" enctype="multipart/form-data">
            
            @csrf
            <input type="hidden" name="id" id="id" value="{{$id}}">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <small><b>Test Category Name</b></small>
                        <input type="text" id="cat_name" value="{{$cat_name}}" name="cat_name" placeholder="Enter test category name..." class="form-control form-control-sm">
                    </div>
                    <div class="col-4">
                        <small><b>Test Category Image</b></small>
                        <input type="file" id="cat_image" name="cat_image" value="{{$cat_image}}" placeholder="Enter test category image..." class="form-control form-control-sm">
                        <img style="width:80px;height:80px;border:1px solid #c2c2c2;  " src="{{ isset($cat_image) && $cat_image ? '/storage/app/' . $cat_image : asset('noimg.png') }}">
                    </div>
                </div><br>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    </script>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('js/admintest.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admintestsections.js') }}"></script>
@endsection
