@extends('layout.main')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-2">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background-color: transparent;">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_attendance_location') }}">Employee
                                        Attendance Location</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Attendance Location</label>
                                <select name="attendance_location_id" class="form-control" disabled>
                                    <option value="{{ $employee_attendance_location->attendance_location->id }}">
                                        {{ $employee_attendance_location->attendance_location->location_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Start Date</label>
                                <input name="start_date" type="date" class="form-control"
                                    value="{{ $employee_attendance_location->start_date }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">End Date</label>
                                <input name="end_date" type="date" class="form-control"
                                    value="{{ $employee_attendance_location->end_date }}" disabled>
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
                                    <a href="{{ route('admin.employee_attendance_location.edit', ['id' => $employee_attendance_location->id]) }}"
                                        class="btn btn-success">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
