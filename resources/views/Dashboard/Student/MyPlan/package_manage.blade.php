@extends('Layouts.student')

@section('css')
@endsection
@section('main')
<div class="container p-0">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-12">
            <i class="bi bi-newspaper text-danger"></i>&nbsp;<b class="text-primary">Test & and Previous Test</b>
        </div>
    </div>
    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-body">
                <table class="table" id="teststable">
                    <thead>
                        <tr>
                            <th scope="col">Test</th>
                            <!-- <th scope="col">Type</th> -->
                            <th scope="col">Class Name</th>
                            <!-- <th scope="col">Created By</th> -->
                            <th scope="col">Created Date</th>
                            <!-- <th scope="col">Sections</th> -->
                            <th scope="col">Questions</th>
                            <!-- <th scope="col">Status</th> -->
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($test as $onetest)
                        <tr>
                            <td>{{$onetest->title}}</td>
                            <td>{{$onetest->class_name}}</td>
                            <td>{{$onetest->created_at}}</td>
                            <td>{{$onetest->total_questions}}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{route('student.test-name', [$onetest->id])}}" title="Start Test"><i class="bi bi-pencil-square me-2"></i>Start Test</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container p-0">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-12">
            <i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp; <b class="text-primary">Study Notes &amp; E-Books</b>
        </div>
    </div>
    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-body">

                <div id="studytable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="dataTables_length" id="studytable_length">
                        <!--<label>Show <select name="studytable_length" aria-controls="studytable" class="form-select form-select-sm"><option value="10">10</option><option value="15">15</option><option value="30">30</option><option value="50">50</option></select> entries</label>-->
                    </div>
                    <table class="table dataTable no-footer" id="studytable" aria-describedby="studytable_info" style="width: 1195px;">
                        <thead>
                            <tr>
                                <th scope="col" class="sorting_disabled sorting_asc" rowspan="1" colspan="1" aria-label="Sr. No." style="width: 61px;">Sr. No.</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Study Subject Title: activate to sort column ascending" style="width: 177px;">Study Subject Title</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Class/Group: activate to sort column ascending" style="width: 124px;">Class/Group</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Content Details: activate to sort column ascending" style="width: 152px;">Content Details</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Format &amp;amp; Availability: activate to sort column ascending" style="width: 199px;">Format &amp; Availability</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Author: activate to sort column ascending" style="width: 131px;">Author</th>
                                <th class="col sorting_disabled" rowspan="1" colspan="1" aria-label="View" style="width: 50px;">View</th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action" style="width: 63px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($study_material as $onematerial)
                            <tr class="odd">
                                <td class="sorting_1">1</td>
                                <td>{{$onematerial->title}}</td>
                                <td>{{$onematerial->name}}</td>
                                <td>{{$onematerial->sub_title}}</td>
                                <td><i class="bi bi-file-pdf"></i> <label style="color: #00A300;">{{$onematerial->publish_status}}</label><br>{{$onematerial->publish_date}}</td>
                                @if($onematerial->institute_id == 0)

                                <td>The Gyanology</td>

                                @else
                                <td>{{auth()->user()->myInstitute?->institute_name ?? ''}}</td>

                                @endif
                                @php
                                $filename = basename($onematerial->file);
                                @endphp


                                <td><a href="http://tests.thegyanology.com/student/material/viewmaterial/{{$filename}}" target="_blank" class="download" data="{{$onematerial->file}}" style="margin:0" auto;display:block;text-align:="" center;="" title="View File">View</a></td>
                                <td><a href="#" class="download" data="{{$onematerial->file}}" style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0" auto;display:block;text-align:="" center;="" title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container p-0">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-12">
            <i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Live &amp; Video Classes</b>
        </div>
    </div>
    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-body">

                <div id="studytable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="dataTables_length" id="studytable_length">
                        <!--<label>Show <select name="studytable_length" aria-controls="studytable" class="form-select form-select-sm"><option value="10">10</option><option value="15">15</option><option value="30">30</option><option value="50">50</option></select> entries</label>-->
                    </div>
                    <table class="table dataTable no-footer" id="studytable" aria-describedby="studytable_info" style="width: 1194px;">
                        <thead>
                            <tr>
                                <th scope="col" class="sorting_disabled sorting_asc" rowspan="1" colspan="1" aria-label="Sr. No." style="width: 60px;">Sr. No.</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Study Subject Title: activate to sort column ascending" style="width: 175px;">Study Subject Title</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Class/Group: activate to sort column ascending" style="width: 123px;">Class/Group</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Content Details: activate to sort column ascending" style="width: 179px;">Content Details</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Format &amp;amp; Availability: activate to sort column ascending" style="width: 196px;">Format &amp; Availability</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Author: activate to sort column ascending" style="width: 112px;">Author</th>
                                <th class="col sorting_disabled" rowspan="1" colspan="1" aria-label="View" style="width: 49px;">View</th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action" style="width: 62px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($live_video as $onevideo)
                            @if($onevideo)
                            <tr class="odd">
                                <td class="sorting_1">1</td>
                                <td>{{$onevideo->plan_name}}</td>
                                <td>{{$onevideo->name ?? ''}}</td>
                                <td>{{$onevideo->sub_title ?? ''}}</td>
                                <td><i class="bi bi-youtube"></i> <label style="color: #00A300;">{{$onevideo->publish_status}}</label><br>{{$onevideo->publish_date}}</td>
                                @if($onevideo->institute_id == 0)

                                <td>The Gyanology</td>

                                @else
                                <td>{{auth()->user()->myInstitute?->institute_name ?? ''}}</td>

                                @endif

                                @if($onevideo->file == 'NA')

                                <td><a href="#" target="_blank" class="download" data="NA" style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0" auto;display:block;text-align:="" center;="" title="View File">View</a></td>
                                <td><a href="{{$onevideo->video_link}}" target="_blank" class="download" data="#" style="margin:0" auto;display:block;text-align:="" center;="" title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a></td>

                                @else
                                @php
                                $filename = basename($onematerial->file);
                                @endphp
                                <td><a href="http://tests.thegyanology.com/student/material/viewmaterial/{{$filename}}" target="_blank" class="download" data="{{$onevideo->file}}" style="margin:0" auto;display:block;text-align:="" center;="" title="View File">View</a></td>
                                <td><a href="#" class="download" data="{{$onevideo->file}}" style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0" auto;display:block;text-align:="" center;="" title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                                @endif

                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container p-0">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-12">
            <i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Static GK &amp; Current Affairs</b>
        </div>
    </div>
    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-body">

                <div id="studytable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="dataTables_length" id="studytable_length">
                        <!--<label>Show <select name="studytable_length" aria-controls="studytable" class="form-select form-select-sm"><option value="10">10</option><option value="15">15</option><option value="30">30</option><option value="50">50</option></select> entries</label>-->
                    </div>
                    <table class="table dataTable no-footer" id="studytable" aria-describedby="studytable_info" style="width: 1195px;">
                        <thead>
                            <tr>
                                <th scope="col" class="sorting_disabled sorting_asc" rowspan="1" colspan="1" aria-label="Sr. No." style="width: 61px;">Sr. No.</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Study Subject Title: activate to sort column ascending" style="width: 177px;">Study Subject Title</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Class/Group: activate to sort column ascending" style="width: 124px;">Class/Group</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Content Details: activate to sort column ascending" style="width: 152px;">Content Details</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Format &amp;amp; Availability: activate to sort column ascending" style="width: 199px;">Format &amp; Availability</th>
                                <th scope="col" class="sorting" tabindex="0" aria-controls="studytable" rowspan="1" colspan="1" aria-label="Author: activate to sort column ascending" style="width: 131px;">Author</th>
                                <th class="col sorting_disabled" rowspan="1" colspan="1" aria-label="View" style="width: 50px;">View</th>
                                <th scope="col" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action" style="width: 63px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($onegk as $one_gk)
                            <tr class="odd">
                                <td class="sorting_1">1</td>
                                <td>{{$one_gk->title}}</td>
                                <td>{{$one_gk->name}}</td>
                                <td>{{$one_gk->sub_title}}</td>
                                <td><i class="bi bi-file-pdf"></i> <label style="color: #00A300;">{{$one_gk->publish_status}}</label><br>{{$one_gk->publish_date}}</td>
                                @if($one_gk->institute_id != 0)

                                <td>The Gyanology</td>

                                @else
                                <td>{{auth()->user()->myInstitute?->institute_name ?? ''}}</td>

                                @endif
                                @if($one_gk->file == 'NA')

                                <td><a href="#" target="_blank" class="download" data="NA" style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0" auto;display:block;text-align:="" center;="" title="View File">View</a></td>
                                <td><a href="#" class="download" data="study_material/StudentStudyMAterialLIsting.pdf" style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0" auto;display:block;text-align:="" center;="" title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>

                                @else
                                @php
                                $filename = basename($one_gk->file);
                                @endphp
                                <td><a href="http://tests.thegyanology.com/student/material/viewmaterial/{{$filename}}" target="_blank" class="download" data="{{$one_gk->file}}" style="margin:0" auto;display:block;text-align:="" center;="" title="View File">View</a></td>
                                <td><a href="http://tests.thegyanology.com/student/material/download/{{$filename}}" class="download" data="{{$filename}}" style="margin:0" auto;display:block;text-align:="" center;="" title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--<div class="dataTables_paginate paging_simple_numbers" id="studytable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="studytable_previous"><a href="#" aria-controls="studytable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="studytable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="studytable_next"><a href="#" aria-controls="studytable" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div>-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
