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
                                <li class="breadcrumb-item"><a href="/admin/shift-daily">Shift Daily</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Shift Daily Code</label>
                                <input name="shift_daily_code" value="{{ $shift_daily->shift_daily_code }}" type="text"
                                    class="form-control" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Day Type</label>
                                <select name="day_type" id="day_type" class="form-control" disabled>
                                    <option value="weekday" {{ $shift_daily->day_type == 'weekday' ? 'selected' : '' }}>
                                        Weekday</option>
                                    <option value="holiday" {{ $shift_daily->day_type == 'holiday' ? 'selected' : '' }}>
                                        Holiday</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Shift Daily Code PH</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Off Day"
                                        name="shift_daily_code_ph" disabled
                                        {{ $shift_daily->shift_daily_code_ph == 'Off Day' ? 'checked' : '' }}>
                                    <label class="form-check-label">Off Day</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Flexible Work Day"
                                        name="shift_daily_code_ph" disabled
                                        {{ $shift_daily->shift_daily_code_ph == 'Flexible Work Day' ? 'checked' : '' }}>
                                    <label class="form-check-label">Flexible Work Day</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="No Changed"
                                        name="shift_daily_code_ph" disabled
                                        {{ $shift_daily->shift_daily_code_ph == 'No Changed' ? 'checked' : '' }}>
                                    <label class="form-check-label">No Changed</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Flexible Shift</label>
                                <div class="form-check">
                                    <input type="hidden" name="flexible_shift" value="{{ $shift_daily->flexible_shift }}">
                                    <input id="flex_check" type="checkbox" class="form-check-input" disabled
                                        {{ $shift_daily->flexible_shift == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Start Time</label>
                                <input name="start_time" value="{{ $shift_daily->start_time }}" type="text"
                                    class="form-control" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">End Time</label>
                                <input name="end_time" value="{{ $shift_daily->end_time }}" type="text"
                                    class="form-control" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Grace for Late</label>
                                <div class="input-group">
                                    <input name="grace_for_late" value="{{ $shift_daily->grace_for_late }}" type="number"
                                        class="form-control" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Minute(s)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Productive Work Time</label>
                                <div class="input-group">
                                    <input name="productive_work_time" value="{{ $shift_daily->productive_work_time }}"
                                        type="number" class="form-control" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Minute(s)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Break Time Start</label>
                                <input name="break_start" value="{{ $shift_daily->break_start }}" type="text"
                                    class="form-control" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Break Time End</label>
                                <input name="break_end" value="{{ $shift_daily->break_end }}" type="text"
                                    class="form-control" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Remark</label>
                                <input name="remark" value="{{ $shift_daily->remark }}" type="text"
                                    class="form-control" disabled>
                            </div>
                            <div class="col-md-8">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.shift_daily.edit', ['id' => $shift_daily->id]) }}" class="btn btn-success">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        const checkbox = document.getElementById('flex_check');
        const hiddenInput = document.querySelector('input[name="flexible_shift"]');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                hiddenInput.value = 1; // Set value to 1 when checked
            } else {
                hiddenInput.value = 0; // Set value to 0 when unchecked
            }
        });
    </script>

@stop
