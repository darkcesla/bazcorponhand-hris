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
                                <li class="breadcrumb-item"><a href="{{ route('admin.deduction') }}">Deduction</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.deduction.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Emplolyee</label>
                                    <select name="employee_id" class="form-control">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Date</label>
                                    <input name="date" type="date" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Payment Start Date</label>
                                    <input name="start_date" type="date" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Payment End Date</label>
                                    <input name="end_date" type="date" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Amount</label><span style="color: red;"> use
                                        (.) as decimal separator</span></label>
                                    <input name="amount" type="number" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Description</label>
                                    <input name="description" type="text" class="form-control">
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

@stop
