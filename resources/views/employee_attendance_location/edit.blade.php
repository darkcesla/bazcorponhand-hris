@extends('layout.main')
@section('content')

    <div class="content-wrapper">
        <div class="content-header">
        </div>
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-2">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background-color: transparent;">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_attendance_location') }}">Employee Attendance Location</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_attendance_location.update', ['id' => $employee_attendance_location->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Attendance Location</label>
                                    <select name="attendance_location_id" class="form-control">
                                        @foreach ($attendanceLocation as $attendanceLocation)
                                            <option value="{{ $attendanceLocation->id }}"
                                                @if ($attendanceLocation->id == $employee_attendance_location->attendance_location_id) selected @endif>
                                                {{ $attendanceLocation->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Start Date</label>
                                    <input name="start_date" type="date" class="form-control" value="{{ $employee_attendance_location->start_date }}">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">End Date</label>
                                    <input name="end_date" type="date" class="form-control" value="{{ $employee_attendance_location->end_date }}">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Employee</label>
                                    <input name="employee_id" type="text" class="form-control"
                                        value="{{ $employee_attendance_location->employee->firstname }} {{ $employee_attendance_location->employee->lastname }}"
                                        disabled>
                                </div>
                                <div class="col-md-8">
                                    <label></label>
                                    <div class=""
                                        style="d-flex justify-content-center align-items-center text-align:center">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@stop
