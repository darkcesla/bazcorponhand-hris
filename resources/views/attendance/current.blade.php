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
                        @if (!empty($attendance))
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Date</label>
                                    <input name="date" value="{{ $attendance->date }}" type="date"
                                        class="form-control" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Shift</label>
                                    <input name="shift_daily_code" value="{{ $attendance->shift_daily->shift_daily_code }}"
                                        type="text" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Checkin Status</label>
                                    <p>{{ $attendance->check_in ? 'already checkin' : 'Not chekin yet' }}</p>
                                </div>
                            </div>
                            @if (!$attendance->check_in)
                                <div class="row">
                                    <div class="col-md-8">
                                        <label></label>
                                        <div class=""
                                            style="d-flex justify-content-center align-items-center text-align:center">
                                            <a href="{{ route('attendance.checkin', ['id' => $attendance->id]) }}"
                                                class="btn btn-success">Check In</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-8">
                                        <label></label>
                                        <div class=""
                                            style="d-flex justify-content-center align-items-center text-align:center">
                                            <a href="{{ route('attendance.checkout', ['id' => $attendance->id]) }}"
                                                class="btn btn-success">Check Out</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <h1>No Attendance Today<h1>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
