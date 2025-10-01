@extends('layout.main')

@section('title', 'Employe')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
        </div>
        <section class="content">
            <div class="container-fluid px-4">
                <div class="card shadow mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-2">
                            <div class="col">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb" style="background-color: transparent;">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.overtime') }}">Employee
                                                Overtime</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Preview</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.overtime.preview') }}" method="get">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="start_date" class="col-form-label form-label">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date"
                                            value="{{ request('start_date') }}" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="end_date" class="col-form-label form-label">End Date:</label>
                                        <input type="date" id="end_date" name="end_date"
                                            value="{{ request('end_date') }}" class="form-control">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end justify-content-left">
                                        <button type="submit" class="btn btn-success">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Day Type</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Total Time</th>
                                                <th>Salary per Hour</th>
                                                <th>Total Salary</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($overtime as $overtime)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <span>{{ $overtime->employee->firstname }}
                                                            {{ $overtime->employee->lastname }} (ID:
                                                            {{ $overtime->employee->employee_no }})</span>
                                                    </td>

                                                    <td>
                                                        <span>{{ $overtime->date }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->day_type }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->start_time }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->end_time }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->total_hour }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->salary_per_hour }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->total_salary }}</span>
                                                    </td>
                                                    <td>
                                                        <span>{{ $overtime->description }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row justify-content-end mt-3">
                                <div class="col-auto">
                                    <form action="{{ route('admin.overtime.export') }}" method="get">
                                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                        <button type="submit" class="btn btn-info">Export</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
