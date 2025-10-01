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
                                <li class="breadcrumb-item"><a href="{{ route('admin.leave-type') }}">Leave Type</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.leave_type.update', ['id' => $leave_type->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Code</label>
                                    <input name="leave_code" type="text" class="form-control"
                                        value={{ $leave_type->leave_code }}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Name</label>
                                    <input name="leave_name" type="text" class="form-control"
                                        value={{ $leave_type->leave_name }}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Eligibility Leave</label>
                                    <input name="eligibility_leave" type="number" class="form-control"
                                        value={{ $leave_type->eligibility_leave }}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label" for="limit_date">Limit Date</label>
                                    <select name="limit_date" id="limit_date" class="form-control">
                                        <option value="1" {{ $leave_type->limit_date == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $leave_type->limit_date == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label" for="deducted_leave">Deducted Leave</label>
                                    <select name="deducted_leave" id="deducted_leave" class="form-control">
                                        <option value="1" {{ $leave_type->deducted_leave == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $leave_type->deducted_leave == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Day Count</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Work Day" name="day_count"
                                            {{ $leave_type->day_count == 'Work Day' ? 'checked' : '' }}>
                                        <label class="form-check-label">Work Day</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Calendar Day" name="day_count"
                                            {{ $leave_type->day_count == 'Calendar Day' ? 'checked' : '' }}>
                                        <label class="form-check-label">Calendar Day</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Day Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Full Day"
                                            name="leave_day_type"
                                            {{ $leave_type->leave_day_type == 'Full Day' ? 'checked' : '' }}>
                                        <label class="form-check-label">Full Day</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Part Of Day"
                                            name="leave_day_type"
                                            {{ $leave_type->leave_day_type == 'Part Of Day' ? 'checked' : '' }}>
                                        <label class="form-check-label">Part Of Day</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Half Day"
                                            name="leave_day_type"
                                            {{ $leave_type->leave_day_type == 'Half Day' ? 'checked' : '' }}>
                                        <label class="form-check-label">Half Day</label>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <label class="col-form-label form-label" for="deducted_leave">Enable Minus</label>
                                    <select name="enable_minus" id="deducted_leave" class="form-control">
                                        <option value="{{ $leave_type->deducted_leave }}">
                                            {{ $leave_type->deducted_leave == 1 ? 'Yes' : 'No' }}</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label" for="leave_period_base_on">Leave
                                        Entitlement Period Based on</label>
                                    <select name="leave_period_base_on" id="leave_period_base_on" class="form-control">
                                        <option value="{{ $leave_type->deducted_leave }}">
                                            {{ $leave_type->deducted_leave == 1 ? 'Yes' : 'No' }}</option>
                                    </select>
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
    <script>
        function toggleRadioButtons() {
            var checkbox = document.getElementById('checkbox');
            var radios = document.getElementsByName('radios');

            if (checkbox.checked) {
                // If checkbox is checked, show radio buttons
                for (var i = 0; i < radios.length; i++) {
                    radios[i].style.display = 'inline-block';
                }
            } else {
                // If checkbox is unchecked, hide radio buttons
                for (var i = 0; i < radios.length; i++) {
                    radios[i].style.display = 'none';
                }
            }
        }
    </script>
@stop
