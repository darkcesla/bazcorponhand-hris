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
                                        <li class="breadcrumb-item active" aria-current="page">KPI</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filter Section -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="attendanceFilter">Filter by Attendance:</label>
                                    <select id="attendanceFilter" class="form-control">
                                        <option value="">All</option>
                                        <option value="-1">All</option>
                                        <option value="1">Present</option>
                                        <option value="2">Late</option>
                                        <option value="3">Absent</option>
                                        <option value="4">On Leave</option>
                                        <option value="5">Sick</option>
                                        <option value="6">Permission</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="performanceFilter">Filter by Performance:</label>
                                    <select id="performanceFilter" class="form-control">
                                        <option value="">All</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Good">Good</option>
                                        <option value="Average">Average</option>
                                        <option value="Poor">Poor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Month</th>
                                            <th>Employee</th>
                                            <th>Attendance</th>
                                            <th>Present</th>
                                            <th>Performance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span>{{ $currentMonth }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->firstname }} {{ $employee->lastname }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->attendance }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->present }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->performance }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
