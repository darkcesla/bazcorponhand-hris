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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_leave_balance') }}">Employee Leave</a></li>
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
                                    <option value="{{ $employee_leave_balance->leave_type_id }}">
                                        {{ $employee_leave_balance->leave_type->leave_name }}</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-8">
                                <label class="col-form-label form-label">Leave Status</label>
                                <select name="leave_status" class="form-control" disabled>
                                    <option value="{{ $employee_leave_balance->leave_status }}">
                                        {{ $employee_leave_balance->leave_status }}</option>
                                </select>
                            </div> --}}
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Employee</label>
                                <input name="employee_id" type="text" class="form-control"
                                    value="{{ $employee_leave_balance->employee->firstname }} {{ $employee_leave_balance->employee->lastname }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Balance</label>
                                <input name="balance" type="text" class="form-control"
                                    value="{{ $employee_leave_balance->balance }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.employee_leave_balance.edit', ['id' => $employee_leave_balance->id]) }}"
                                        class="btn btn-success">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
