@extends('Layouts.admin')

@section('main')
    <section class="content admin-1 border-dark border">
        @php
            $showEducationType = false;
            $showClassGroup = false;
            foreach ($data['user'] as $list) {
                if (!empty($list->education_type_name)) {
                    $showEducationType = true;
                }
                if (!empty($list->class_name)) {
                    $showClassGroup = true;
                }
                if ($showEducationType && $showClassGroup) {
                    break;
                }
            }
        @endphp
        <div class="heading">
            <h5 style="font-size: 18px;">{{ $data['page_title'] }}</h5>
            <button class="btn btn-success" type="button" style="" onclick="printTable()">Print Form</button>
        </div>

        <div class="row p-3">
            <div class="table-responsive">
                <table class="table-bordered datatable table" id="studentstable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Student Name</th>
                            @if ($showEducationType)
                                <th>Education Type</th>
                            @endif
                            @if ($showClassGroup)
                                <th>Class Group</th>
                            @endif
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Institute Name & Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data['user'] as $key => $list)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img id="profile_img"
                                        src="{{ isset($list) && optional($list->user_details)->photo_url ? '/storage/' . $list->user_details->photo_url : asset('noimg.png') }}"
                                        style="width:80px;height:80px;border:1px solid #c2c2c2;  ">
                                </td>
                                <td>{{ $list->name }}</td>
                                @if ($showEducationType)
                                    <td>{{ $list->education_type_name }}</td>
                                @endif
                                @if ($showClassGroup)
                                    <td>{{ $list->class_name }}</td>
                                @endif
                                <td>{{ $list->email }}</td>
                                <td>{{ $list->mobile }}</td>
                                <td>{{ $list->institute_name }}<br>{{ $list->institute_code }}</td>
                                <td>{{ $list->status }}</td>
                                <td class="text-end">
                                    <a class="btn btn-success" href="{{ route('administrator.user_show', $list->id) }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @if ($data['franchise_status'])
                                        <a class="deletebutton btn btn-danger ms-1"
                                            href="{{ route('administrator.user_delete', $list->id) }}">
                                            <i class="bi bi-trash2"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
