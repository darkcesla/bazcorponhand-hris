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
                                        <li class="breadcrumb-item active" aria-current="page">Shift Daily</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.shift_daily.create') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Shift Daily Code</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Break Time</th>
                                            <th>Day Type</th>
                                            <th>Flexible Shift</th>
                                            <th>Remark</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shift_daily as $shift_daily)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span>{{ $shift_daily->shift_daily_code }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $shift_daily->start_time }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $shift_daily->end_time }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ Carbon\Carbon::parse($shift_daily->break_start)->format('H:i') }}
                                                        -
                                                        {{ Carbon\Carbon::parse($shift_daily->break_end)->format('H:i') }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $shift_daily->day_type }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $shift_daily->flexible_shift }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $shift_daily->remark }}</span>
                                                </td>
                                                <td style="width: 10px;align= center">
                                                    <a
                                                        href="{{ route('admin.shift_daily.show', ['id' => $shift_daily->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                    </a>
                                                    <a
                                                        href="{{ route('admin.shift_daily.edit', ['id' => $shift_daily->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-pencil-alt"></i> <!-- Icon pensil (pencil) -->
                                                        </span>
                                                    </a>
                                                    <form id="deleteForm{{ $shift_daily->id }}"
                                                        action="{{ route('admin.shift_daily.destroy', ['id' => $shift_daily->id]) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="#"
                                                        onclick="event.preventDefault(); $('#deleteConfirmationModal{{ $shift_daily->id }}').modal('show');">
                                                        <span class="icon">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </span>
                                                    </a>
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
    <script>
        function submitDeleteForm(id) {
            const form = document.getElementById(`deleteForm${id}`);
            form.submit();
        }
    </script>
@stop
