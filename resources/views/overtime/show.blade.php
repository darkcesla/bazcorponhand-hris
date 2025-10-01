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
                                <li class="breadcrumb-item"><a href="{{ route('admin.overtime') }}">Employee Overtime</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Employee</label>
                                <select id="employee_id" name="employee_id" class="form-control" disabled>
                                    <option value="{{ $overtime->employee_id }}">
                                        {{ $overtime->employee->firstname }}
                                        {{ $overtime->employee->lastname }}(ID:
                                        {{ $overtime->employee->employee_no }})</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Day Type</label>
                                <select name="day_type" id="day_type" class="form-control" disabled>
                                    <option value="Weekday" {{ $overtime->day_type == 'Weekday' ? 'selected' : '' }}>
                                        Weekday</option>
                                    <option value="Holiday" {{ $overtime->day_type == 'Holiday' ? 'selected' : '' }}>
                                        Holiday</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Date</label>
                                <input name="date" type="date" class="form-control" value="{{ $overtime->date }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Start Time</label>
                                <input name="start_time" type="time" class="form-control"
                                    value="{{ $overtime->start_time }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">End Time</label>
                                <input name="end_time" type="time" class="form-control" value="{{ $overtime->end_time }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Description</label>
                                <textarea name="description" class="form-control text-left" rows="3" disabled>{{ $overtime->description }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Total Hour</label>
                                <input name="total_hour" type="text" class="form-control"
                                    value="{{ $overtime->total_hour }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Salary per hour</label>
                                <input name="salary_per_hour" type="text" class="form-control"
                                    value="{{ $overtime->salary_per_hour }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Total Salary</label>
                                <input name="total_salary" type="text" class="form-control"
                                    value="{{ $overtime->total_salary }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.overtime.edit', ['id' => $overtime->id]) }}"
                                        class="btn btn-success">Edit</a>
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
