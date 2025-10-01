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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_leave_history') }}">Employee Leave History</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Leave Type</label>
                                <select name="leave_type_id" class="form-control" disabled>
                                    <option value="{{ $employee_leave_history->leave_type_id }}">{{ $employee_leave_history->leave_type->leave_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Start Date</label>
                                <input name="start_date" type="date" class="form-control"
                                    value="{{ $employee_leave_history->start_date }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">End Date</label>
                                <input name="end_date" type="date" class="form-control"
                                    value="{{ $employee_leave_history->end_date }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Day Count</label>
                                <input name="day_count_display" type="text" class="form-control"
                                    value="{{ $employee_leave_history->day_count }}" disabled>
                                <input name="day_count" type="hidden" value="{{ $employee_leave_history->day_count }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Notes</label>
                                <input name="notes" type="text" class="form-control"
                                    value="{{ $employee_leave_history->notes }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.employee_leave_history.edit', ['id' => $employee_leave_history->id]) }}"
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
