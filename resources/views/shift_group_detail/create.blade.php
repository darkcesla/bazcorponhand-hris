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
                                <li class="breadcrumb-item"><a href="/admin/shift-daily">Shift Daily</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.shift_daily.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Shift Daily Code</label>
                                    <input name="shift_daily_code" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Day Type</label>
                                    <select name="day_type" id="day_type" class="form-control" required>
                                        <option value="weekday"> Weekday</option>
                                        <option value="holiday"> Holiday</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Shift Daily Code PH</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Off Day"
                                            name="shift_daily_code_ph">
                                        <label class="form-check-label">Off Day</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Flexible Work Day"
                                            name="shift_daily_code_ph">
                                        <label class="form-check-label">Flexible Work Day</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="No Changed"
                                            name="shift_daily_code_ph" checked>
                                        <label class="form-check-label">No Changed</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Flexible Shift</label>
                                    <div class="form-check">
                                        <input type="hidden" name="flexible_shift" value="0">
                                        <input id="flex_check" type="checkbox" class="form-check-input" value="1">
                                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Start Time</label>
                                    <input name="start_time" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">End Time</label>
                                    <input name="end_time" type="text" class="form-control" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Grace for Late</label>
                                    <div class="input-group">
                                        <input name="grace_for_late" type="number" class="form-control" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Minute(s)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Productive Work Time</label>
                                    <div class="input-group">
                                        <input name="productive_work_time" type="number" class="form-control" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Minute(s)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Break Time Start</label>
                                    <input name="break_start" type="text" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Break Time End</label>
                                    <input name="break_end" type="text" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Remark</label>
                                    <input name="remark" type="text" class="form-control">
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
