@extends('layout.main')

@section('title', 'Employe')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Shift Group</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shift Group</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid px-4">
                <div class="card shadow mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="container-fluid px-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Leave Code</label>
                                        <input name="leave_code" type="text" class="form-control"
                                            value={{ $leave_type->leave_code }} disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Leave Name</label>
                                        <input name="leave_name" type="text" class="form-control"
                                            value={{ $leave_type->leave_name }} disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Eligibility Leave</label>
                                        <input name="eligibility_leave" type="text" class="form-control"
                                            value={{ $leave_type->eligibility_leave }} disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label" for="limit_date">Limit Date</label>
                                        <select name="limit_date" id="limit_date" class="form-control" disabled>
                                            <option value="{{ $leave_type->limit_date }}">
                                                {{ $leave_type->limit_date == 1 ? 'Yes' : 'No' }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label" for="deducted_leave">Deducted Leave</label>
                                        <select name="deducted_leave" id="deducted_leave" class="form-control" disabled>
                                            <option value="{{ $leave_type->deducted_leave }}">
                                                {{ $leave_type->deducted_leave == 1 ? 'Yes' : 'No' }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Day Count</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="Work Day" name="day_count"
                                                {{ $leave_type->day_count == 'Work Day' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label">Work Day</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="Calendar Day"
                                                name="day_count"
                                                {{ $leave_type->day_count == 'Calendar Day' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label">Calendar Day</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Leave Day Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="Full Day"
                                                name="leave_day_type"
                                                {{ $leave_type->leave_day_type == 'Full Day' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label">Full Day</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="Part Of Day"
                                                name="leave_day_type"
                                                {{ $leave_type->leave_day_type == 'Part Of Day' ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label">Part Of Day</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="Half Day"
                                                name="leave_day_type"
                                                {{ $leave_type->leave_day_type == 'Half Day' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label">Half Day</label>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <label class="col-form-label form-label" for="deducted_leave">Enable Minus</label>
                                        <select name="enable_minus" id="deducted_leave" class="form-control" disabled>
                                            <option value="{{ $leave_type->deducted_leave }}">
                                                {{ $leave_type->deducted_leave == 1 ? 'Yes' : 'No' }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label" for="leave_period_base_on">Leave
                                            Entitlement Period Based on</label>
                                        <select name="leave_period_base_on" id="leave_period_base_on" class="form-control"
                                            disabled>
                                            <option value="{{ $leave_type->deducted_leave }}">
                                                {{ $leave_type->deducted_leave == 1 ? 'Yes' : 'No' }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label></label>
                                        <div class=""
                                            style="d-flex justify-content-center align-items-center text-align:center">
                                            <a href="{{ route('admin.leave_type.edit', ['id' => $leave_type->id]) }}"
                                                class="btn btn-success">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
