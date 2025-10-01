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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_shift') }}">Employee Shift</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Shift Daily</label>
                                <select name="shift_daily_id" class="form-control" disabled>
                                    <option value="{{ $employee_shift->shift_daily_id }}">
                                        {{ $employee_shift->shift_daily->shift_daily_code }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Start Shift Date</label>
                                <input name="date" type="date" class="form-control"
                                    value="{{ $employee_shift->date }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">End Shift Date</label>
                                <input name="end_date" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Employee</label>
                                <input name="employee_id" type="text" class="form-control"
                                    value="{{ $employee_shift->employee->firstname }} {{ $employee_shift->employee->lastname }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label></label>
                            <div class="" style="d-flex justify-content-center align-items-center text-align:center">
                                <a href="{{ route('admin.employee_shift.edit', ['id' => $employee_shift->id]) }}"
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
