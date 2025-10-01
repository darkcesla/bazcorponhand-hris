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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_payroll') }}">Employee Payroll</a></li>
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
                                    <option value="{{ $employee_payroll->employee_id }}">
                                        {{ $employee_payroll->employee->firstname }}
                                        {{ $employee_payroll->employee->lastname }}(ID:
                                        {{ $employee_payroll->employee->employee_no }})</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Effective Salary Date</label>
                                <input name="effective_salary_date" type="date" class="form-control"
                                    value="{{ $employee_payroll->effective_salary_date }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Title</label>
                                <input name="title" type="text" class="form-control" value="{{ $employee_payroll->title }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Tax Flag</label>
                                <select name="tax_flag" id="tax_flag" class="form-control" disabled>
                                    <option value="0" {{ $employee_payroll->tax_flag == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $employee_payroll->tax_flag == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Tax Number</label>
                                <input name="tax_number" type="text" class="form-control" value="{{ $employee_payroll->tax_number }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Tax Type</label>
                                <input name="tax_type" type="text" class="form-control" value="{{ $employee_payroll->tax_type }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Salary Received</label>
                                <select id="salary_received" name="salary_received" class="form-control" disabled>
                                    <option value="Gross" {{ $employee_payroll->salary_received === 'Gross' ? 'selected' : '' }}>Gross</option>
                                    <option value="Net" {{ $employee_payroll->salary_received === 'Net' ? 'selected' : '' }}>Net</option>
                                    <option value="Gross On Top" {{ $employee_payroll->salary_received === 'Gross On Top' ? 'selected' : '' }}>Gross On Top</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">BPJS TK</label>
                                <input name="bpjs_ketenagakerjaan" type="text" class="form-control" value="{{ $employee_payroll->bpjs_ketenagakerjaan }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">BPJS Kesehatan</label>
                                <input name="bpjs_kesehatan" type="text" class="form-control" value="{{ $employee_payroll->bpjs_kesehatan }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Private Insurance</label>
                                <input name="insurance" type="text" class="form-control" value="{{ $employee_payroll->insurance }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Private Insurance Number</label>
                                <input name="insurance_number" type="text" class="form-control" value="{{ $employee_payroll->insurance_number }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Basic Salary</label>
                                <input name="basic_salary" type="text" class="form-control" value="{{ $employee_payroll->basic_salary }}" disabled>
                            </div>
                        </div>
                        @foreach ($allowances as $allowanceType => $allowance)
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="col-form-label form-label">Date for Allowance
                                        {{ $allowanceType }}</label>
                                    <input type="text" class="form-control" value="{{ $allowance['date'] }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label form-label">Amount for Allowance
                                        {{ $allowanceType }}</label>
                                    <input type="text" class="form-control" value="{{ $allowance['amount'] }}"
                                        readonly>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-6">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.employee_payroll.edit', ['id' => $employee_payroll->id]) }}"
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
