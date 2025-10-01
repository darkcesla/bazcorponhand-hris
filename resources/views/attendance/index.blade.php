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
                                        <li class="breadcrumb-item active" aria-current="page">Employee Attendance</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.attendance.create') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                            </div>
                            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                                <div class="col-auto">
                                    <a href="{{ route('admin.attendance.report') }}" class="btn btn-info"
                                        style="padding: 0.1rem 0.5rem;"><i class="fas fa-eye"></i></a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Employee</th>
                                            <th>Shift</th>
                                            <th>Shift Start</th>
                                            <th>Check In</th>
                                            <th>Shift End</th>
                                            <th>Check Out</th>
                                            <th>Status</th>
                                            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendance as $attendance)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span>{{ $attendance->date }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->employee->firstname }}
                                                        {{ $attendance->employee->lastname }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->shift_daily->shift_daily_code }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->shift_daily->start_time }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->check_in }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->shift_daily->end_time }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->check_out }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $attendance->status }}</span>
                                                </td>
                                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                                                    <td style="width: 10px;align= center">
                                                        <a
                                                            href="{{ route('admin.attendance.show', ['id' => $attendance->id]) }}">
                                                            <span class="icon">
                                                                <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </a>
                                                        <a
                                                            href="{{ route('admin.attendance.edit', ['id' => $attendance->id]) }}">
                                                            <span class="icon">
                                                                <i class="fas fa-pencil-alt"></i>
                                                                <!-- Icon pensil (pencil) -->
                                                            </span>
                                                        </a>
                                                        <form id="deleteForm{{ $attendance->id }}"
                                                            action="{{ route('admin.attendance.destroy', ['id' => $attendance->id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <a href="#"
                                                            onclick="event.preventDefault(); $('#deleteConfirmationModal{{ $attendance->id }}').modal('show');">
                                                            <span class="icon">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </span>
                                                        </a>
                                                    </td>
                                                @endif
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
