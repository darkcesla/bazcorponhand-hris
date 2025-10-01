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
                                <li class="breadcrumb-item"><a href="{{ route('admin.attendance') }}">Employee Attendance</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Date</label>
                                <input name="remark" value="{{ $attendance->date }}" type="date"
                                    class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Employee</label>
                                <select id="employee_id" name="employee_id" class="form-control" disabled>
                                    <option value="{{ $attendance->employee_id }}">
                                        {{ $attendance->employee->firstname }}
                                        {{ $attendance->employee->lastname }}(ID:
                                        {{ $attendance->employee->employee_no }})</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Attendance Location</label>
                                <select name="attendance_location_id" class="form-control" disabled>
                                    <option value="{{ $attendance->attendance_location_id }}">
                                        {{ $attendance->attendance_location->location_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.attendance.edit', ['id' => $attendance->id]) }}"
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
