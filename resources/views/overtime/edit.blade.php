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
                                <li class="breadcrumb-item"><a href="{{ route('admin.overtime') }}">Employee Overtime</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.overtime.update', ['id' => $overtime->id]) }}" method="post">
                        @csrf
                        @method('PUT')
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
                                    <select name="day_type" id="day_type" class="form-control" required>
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
                                    <input name="date" type="date" class="form-control" value="{{ $overtime->date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Start Time</label>
                                    <input name="start_time" type="time" class="form-control"
                                        value="{{ $overtime->start_time }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">End Time</label>
                                    <input name="end_time" type="time" class="form-control"
                                        value="{{ $overtime->end_time }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Description</label>
                                    <textarea name="description" class="form-control text-left" rows="3">{{ $overtime->description }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Total Hour</label>
                                    <input id="total_hour" name="total_hour" type="text" class="form-control"
                                        value="{{ $overtime->total_hour }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Salary per hour</label>
                                    <input id="salary_per_hour" name="salary_per_hour" type="text" class="form-control"
                                        value="{{ $overtime->salary_per_hour }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Total Salary</label>
                                    <input id="total_salary" name="total_salary" type="text" class="form-control"
                                        value="{{ $overtime->total_salary }}" id="total_salary" readonly>
                                </div>
                            </div>
                            <div class="row">
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
    <script>
        $(document).ready(function() {
            $('#total_hour, #salary_per_hour').on('input', function() {
                var totalHour = parseFloat($('#total_hour').val()) || 0;
                var salaryPerHour = parseFloat($('#salary_per_hour').val()) || 0;
                var totalSalary = totalHour * salaryPerHour;
                $('#total_salary').val(totalSalary.toFixed(2));
            });
        });
    </script>

@stop
