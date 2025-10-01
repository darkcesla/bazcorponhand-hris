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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee') }}">Employee</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('selected_company') == 0)
                    <div class="alert alert-warning" role="alert">
                        <strong>Note:</strong> Please make sure to switch the company from the dropdown above before creating employee data.
                      </div>
                      @endif
                    <ul class="nav nav-tabs" id="employeeTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab"
                                aria-controls="personal" aria-selected="true">Personal<span style="color: red;">
                                    *</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="employment-tab" data-toggle="tab" href="#employment" role="tab"
                                aria-controls="employment" aria-selected="false">Employment<span style="color: red;">
                                    *</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="education-tab" data-toggle="tab" href="#education" role="tab"
                                aria-controls="education" aria-selected="false">Education &
                                Experience</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab"
                                aria-controls="bank" aria-selected="false">Bank</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                aria-controls="contact" aria-selected="false">Contact</a>
                        </li>
                    </ul>
                    <form action="{{ route('admin.employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="tab-content" id="employeeTabContent">
                                <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                    aria-labelledby="personal-tab">
                                    @include('employee.forms.create.personal')

                                </div>
                                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                                    @include('employee.forms.create.education')
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="col-form-label form-label">Emergency Contact Name</label>
                                            <input name="emergency_contact_name" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label form-label">Emergency Contact Number</label>
                                            <input name="emergency_contact_number" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label form-label">Bank Name</label>
                                            <input name="bank_name" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label form-label">Account Number</label>
                                            <input name="account_number" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label form-label">Account Name</label>
                                            <input name="account_name" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="employment" role="tabpanel"
                                    aria-labelledby="employment-tab">
                                    @include('employee.forms.create.employment')
                                </div>
                                <div class="col-md-8">
                                    <label></label>
                                    <div class=""
                                        style="d-flex justify-content-center align-items-center text-align:center">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
    </div>
    </section>
    </div>

@stop
