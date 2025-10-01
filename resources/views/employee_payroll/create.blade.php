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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_payroll') }}">Employee Payroll</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_payroll.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Employee</label>
                                    <select id="employee_id" name="employee_id" class="form-control">
                                        @foreach ($employee as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->name }} (ID:
                                                {{ $emp->employee_no }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Effective Salary Date</label>
                                    <input name="effective_salary_date" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Title</label>
                                    <input name="title" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Tax Flag</label>
                                    <select name="tax_flag" id="tax_flag" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Tax Number</label>
                                    <input name="tax_number" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Tax Type</label>
                                    <input name="tax_type" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Salary Received</label>
                                    <select id="salary_received" name="salary_received" class="form-control">
                                        <option value="Gross">Gross</option>
                                        <option value="Net">Net</option>
                                        <option value="Gross On Top">Gross On Top</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">BPJS TK</label>
                                    <input name="bpjs_ketenagakerjaan" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">BPJS Kesehatan</label>
                                    <input name="bpjs_kesehatan" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Private Insurance</label>
                                    <input name="insurance" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Private Insurance Number</label>
                                    <input name="insurance_number" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Basic Salary</label>
                                    <input name="basic_salary" type="text" class="form-control" required>
                                </div>
                            </div>
                            @foreach ($allowanceTypes as $allowanceType)
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="allowance_amount_{{ $allowanceType->id }}"
                                                class="col-form-label form-label">{{ $allowanceType->name }}
                                                Allowance</label>
                                            <input type="number" id="allowance_amount_{{ $allowanceType->id }}"
                                                name="allowances[{{ $allowanceType->id }}][amount]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="hidden" name="allowances[{{ $allowanceType->id }}][name]"
                                                value="{{ $allowanceType->name }} Allowance">
                                            <label for="allowance_date_{{ $allowanceType->id }}"
                                                class="col-form-label form-label"> Effective Date</label>
                                            <input type="date" id="allowance_date_{{ $allowanceType->id }}"
                                                name="allowances[{{ $allowanceType->id }}][date]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-md-6">
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
