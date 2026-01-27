@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-12">
                <i class="bi bi-newspaper text-danger"></i>&nbsp;<b class="text-primary">Test &amp; Previous Test</b>
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
                            @foreach ($test as $onetest)
                                <tr>
                                    <td>{{ $onetest->title }}</td>
                                    <td>{{ $onetest->class_name }}</td>
                                    <td>{{ $onetest->created_at }}</td>
                                    <td>{{ $onetest->total_questions }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('student.test-name', [$onetest->id]) }}" title="Start Test"><i
                                                class="bi bi-pencil-square me-2"></i>Start Test</a>
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
                <i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i
                    class="bi bi-file-excel text-success"></i>&nbsp; <b class="text-primary">Study Notes &amp; E-Books</b>
            </div>
        </div>
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">

                    <div class="dataTables_wrapper dt-bootstrap5 no-footer" id="studytable_wrapper">
                        <div class="dataTables_length" id="studytable_length">
                        </div>
                        <table class="dataTable no-footer table" id="studytable" aria-describedby="studytable_info"
                            style="width: 1195px;">
                            <thead>
                                <tr>
                                    <th class="sorting_disabled sorting_asc" aria-label="Sr. No." style="width: 61px;"
                                        scope="col" rowspan="1" colspan="1">Sr. No.</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Study Subject Title: activate to sort column ascending" tabindex="0"
                                        style="width: 177px;" scope="col" rowspan="1" colspan="1">Study Subject
                                        Title</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Class/Group: activate to sort column ascending" tabindex="0"
                                        style="width: 124px;" scope="col" rowspan="1" colspan="1">Class/Group</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Content Details: activate to sort column ascending" tabindex="0"
                                        style="width: 152px;" scope="col" rowspan="1" colspan="1">Content Details
                                    </th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Format &amp;amp; Availability: activate to sort column ascending"
                                        tabindex="0" style="width: 199px;" scope="col" rowspan="1" colspan="1">
                                        Format &amp; Availability</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Author: activate to sort column ascending" tabindex="0"
                                        style="width: 131px;" scope="col" rowspan="1" colspan="1">Created By</th>
                                    <th class="col sorting_disabled" aria-label="View" style="width: 50px;" rowspan="1"
                                        colspan="1">View</th>
                                    <th class="sorting_disabled" aria-label="Action" style="width: 63px;" scope="col"
                                        rowspan="1" colspan="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($study_material as $onematerial)
                                    <tr class="odd">
                                        <td class="sorting_1">1</td>
                                        <td>{{ $onematerial->title }}</td>
                                        <td>{{ $onematerial->name }}</td>
                                        <td>{{ $onematerial->sub_title }}</td>
                                        <td><i class="bi bi-file-pdf"></i> <label
                                                style="color: #00A300;">{{ $onematerial->publish_status }}</label><br>{{ $onematerial->publish_date }}
                                        </td>
                                        @if ($onematerial->institute_id == 0)
                                            <td>Test and Notes</td>
                                        @else
                                            <td>{{ auth()->user()->myInstitute?->institute_name ?? '' }}</td>
                                        @endif
                                        @php
                                            $filename = basename($onematerial->file);
                                        @endphp


                                        <td><a class="download"
                                                href="http://testandnotes.com/student/material/viewmaterial/{{ $filename }}"
                                                title="View File" style="margin:0" target="_blank"
                                                data="{{ $onematerial->file }}">View</a></td>
                                        {{-- <td><a href="#" class="download" data="{{$onematerial->file}}" style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0"  title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td> --}}
                                        <td><a href="{{ url('/storage/study_material/' . $onematerial->file) }}"
                                                title="Download File"
                                                style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0"
                                                download><i class="bi bi-download text-danger me-2"
                                                    aria-hidden="true"></i></a></td>
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
                <i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i
                    class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Live &amp; Video Classes</b>
            </div>
        </div>
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">

                    <div class="dataTables_wrapper dt-bootstrap5 no-footer" id="studytable_wrapper">
                        <div class="dataTables_length" id="studytable_length">
                        </div>
                        <table class="dataTable no-footer table" id="studytable" aria-describedby="studytable_info"
                            style="width: 1194px;">
                            <thead>
                                <tr>
                                    <th class="sorting_disabled sorting_asc" aria-label="Sr. No." style="width: 60px;"
                                        scope="col" rowspan="1" colspan="1">Sr. No.</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Study Subject Title: activate to sort column ascending" tabindex="0"
                                        style="width: 175px;" scope="col" rowspan="1" colspan="1">Study Subject
                                        Title</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Class/Group: activate to sort column ascending" tabindex="0"
                                        style="width: 123px;" scope="col" rowspan="1" colspan="1">Class/Group
                                    </th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Content Details: activate to sort column ascending" tabindex="0"
                                        style="width: 179px;" scope="col" rowspan="1" colspan="1">Content
                                        Details</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Format &amp;amp; Availability: activate to sort column ascending"
                                        tabindex="0" style="width: 196px;" scope="col" rowspan="1"
                                        colspan="1">Format &amp; Availability</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Author: activate to sort column ascending" tabindex="0"
                                        style="width: 112px;" scope="col" rowspan="1" colspan="1">Created By
                                    </th>
                                    <th class="col sorting_disabled" aria-label="View" style="width: 49px;"
                                        rowspan="1" colspan="1">View</th>
                                    <th class="sorting_disabled" aria-label="Action" style="width: 62px;" scope="col"
                                        rowspan="1" colspan="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($live_video as $onevideo)
                                    @if ($onevideo)
                                        <tr class="odd">
                                            <td class="sorting_1">1</td>
                                            <td>{{ $onevideo->title ?? '' }}</td>
                                            <td>{{ $onevideo->name ?? '' }}</td>
                                            <td>{{ $onevideo->sub_title ?? '' }}</td>
                                            <td><i class="bi bi-youtube"></i> <label
                                                    style="color: #00A300;">{{ $onevideo->publish_status }}</label><br>{{ $onevideo->publish_date }}
                                            </td>
                                            @if ($onevideo->institute_id == 0)
                                                <td>Test and Notes</td>
                                            @else
                                                <td>{{ auth()->user()->myInstitute?->institute_name ?? '' }}</td>
                                            @endif

                                            @if ($onevideo->file == 'NA')
                                                <td><a class="download" href="#" title="View File"
                                                        style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0"
                                                        target="_blank" data="NA">View</a></td>
                                                <td><a class="download" href="{{ $onevideo->video_link }}"
                                                        title="View Video" style="margin:0" target="_blank"
                                                        data="#"><i class="bi bi-play text-danger me-2"
                                                            aria-hidden="true"></i></a></td>
                                            @else
                                                @php
                                                    $filename = basename($onevideo->file);
                                                @endphp
                                                <td><a class="download"
                                                        href="/student/material/viewmaterial/{{ $filename }}"
                                                        title="View File" style="margin:0" target="_blank"
                                                        data="{{ $onevideo->file }}">View</a></td>
                                                <td><a href="{{ url('/storage/study_material/' . $onevideo->file) }}"
                                                        title="Download File"
                                                        style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0"
                                                        download><i class="bi bi-download text-danger me-2"
                                                            aria-hidden="true"></i></a></td>
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
                <i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i
                    class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i
                    class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b
                    class="text-primary">Static GK &amp; Current Affairs</b>
            </div>
        </div>
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">

                    <div class="dataTables_wrapper dt-bootstrap5 no-footer" id="studytable_wrapper">
                        <div class="dataTables_length" id="studytable_length">
                            <!--<label>Show <select class="form-select form-select-sm" name="studytable_length" aria-controls="studytable"><option value="10">10</option><option value="15">15</option><option value="30">30</option><option value="50">50</option></select> entries</label>-->
                        </div>
                        <table class="dataTable no-footer table" id="studytable" aria-describedby="studytable_info"
                            style="width: 1195px;">
                            <thead>
                                <tr>
                                    <th class="sorting_disabled sorting_asc" aria-label="Sr. No." style="width: 61px;"
                                        scope="col" rowspan="1" colspan="1">Sr. No.</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Study Subject Title: activate to sort column ascending" tabindex="0"
                                        style="width: 177px;" scope="col" rowspan="1" colspan="1">Study Subject
                                        Title</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Class/Group: activate to sort column ascending" tabindex="0"
                                        style="width: 124px;" scope="col" rowspan="1" colspan="1">Class/Group
                                    </th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Content Details: activate to sort column ascending" tabindex="0"
                                        style="width: 152px;" scope="col" rowspan="1" colspan="1">Content
                                        Details</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Format &amp;amp; Availability: activate to sort column ascending"
                                        tabindex="0" style="width: 199px;" scope="col" rowspan="1"
                                        colspan="1">Format &amp; Availability</th>
                                    <th class="sorting" aria-controls="studytable"
                                        aria-label="Author: activate to sort column ascending" tabindex="0"
                                        style="width: 131px;" scope="col" rowspan="1" colspan="1">Created By
                                    </th>
                                    <th class="col sorting_disabled" aria-label="View" style="width: 50px;"
                                        rowspan="1" colspan="1">View</th>
                                    <th class="sorting_disabled" aria-label="Action" style="width: 63px;" scope="col"
                                        rowspan="1" colspan="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($onegk as $one_gk)
                                    @if ($one_gk)
                                        <tr class="odd">
                                            <td class="sorting_1">1</td>
                                            <td>{{ $one_gk->title }}</td>
                                            <td>{{ $one_gk->name }}</td>
                                            <td>{{ $one_gk->sub_title }}</td>
                                            <td><i class="bi bi-file-pdf"></i> <label
                                                    style="color: #00A300;">{{ $one_gk->publish_status }}</label><br>{{ $one_gk->publish_date }}
                                            </td>
                                            @if ($one_gk->institute_id == 0)
                                                <td>Test and Notes</td>
                                            @else
                                                <td>{{ auth()->user()->myInstitute?->institute_name ?? '' }}</td>
                                            @endif
                                            @if ($one_gk->file == 'NA')
                                                <td><a class="download" href="#" title="View File"
                                                        style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0"
                                                        target="_blank" data="NA">View</a></td>
                                                <td><a class="download" href="#" title="Download File"
                                                        style="color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0"
                                                        data="study_material/StudentStudyMAterialLIsting.pdf"><i
                                                            class="bi bi-download text-danger me-2"
                                                            aria-hidden="true"></i></a></td>
                                            @else
                                                @php
                                                    $filename = basename($one_gk->file);
                                                @endphp
                                                <td><a class="download"
                                                        href="http://testandnotes.com/student/material/viewmaterial/{{ $filename }}"
                                                        title="View File" style="margin:0" target="_blank"
                                                        data="{{ $one_gk->file }}">View</a></td>
                                                <td><a href="{{ url('/storage/study_material/' . $filename) }}"
                                                        title="Download File" style="margin:0" download><i
                                                            class="bi bi-download text-danger me-2"
                                                            aria-hidden="true"></i></a></td>
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
@endsection
