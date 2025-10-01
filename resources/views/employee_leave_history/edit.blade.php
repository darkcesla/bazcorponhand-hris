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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_leave_history') }}">Employee Leave History</a></li>
                                        History</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_leave_history.update', ['id' => $employee_leave_history->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Type</label>
                                    <select name="leave_type_id" class="form-control">
                                        @foreach ($leave_type as $leave_type)
                                            <option value="{{ $leave_type->id }}">{{ $leave_type->leave_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Start Date</label>
                                    <input name="start_date" type="date" class="form-control" value="{{ $employee_leave_history->start_date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">End Date</label>
                                    <input name="end_date" type="date" class="form-control" value="{{ $employee_leave_history->end_date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Day Count</label>
                                    <input name="day_count_display" type="text" class="form-control" value="{{ $employee_leave_history->day_count }}" disabled>
                                    <input name="day_count" type="hidden" value="{{ $employee_leave_history->day_count }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Notes</label>
                                    <input name="notes" type="text" class="form-control" value="{{ $employee_leave_history->notes }}">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="start_date"], input[name="end_date"]').change(function() {
                var startDate = new Date($('input[name="start_date"]').val());
                var endDate = new Date($('input[name="end_date"]').val());
    
                if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    
                    // Set value for display and hidden input fields
                    $('input[name="day_count_display"]').val(diffDays + 1);
                    $('input[name="day_count"]').val(diffDays + 1);
                }
            });
        });
    </script>


@stop
