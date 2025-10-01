@extends('layout.main')

@section('title', 'Overtime')

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
                                        <li class="breadcrumb-item active" aria-current="page">Employee Overtime</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.overtime.create') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                            </div>
                            @if (auth()->user()->role === 'admin')
                                <div class="col-auto">
                                    <a href="{{ route('admin.overtime.preview') }}" class="btn btn-info"
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
                                            @if (auth()->user()->role === 'admin')
                                                <th>Employee</th>
                                            @endif
                                            <th>Date</th>
                                            <th>Day Type</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Total Time</th>
                                            <th>Salary per Hour</th>
                                            <th>Total Salary</th>
                                            <th>Description</th>
                                            @if (auth()->user()->role === 'admin')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($overtime as $overtime)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @if (auth()->user()->role === 'admin')
                                                    <td>
                                                        <span>{{ $overtime->employee->firstname }}
                                                            {{ $overtime->employee->lastname }}</span>
                                                    </td>
                                                @endif
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
                                                @if (auth()->user()->role === 'admin')
                                                    <td style="width: 10px;align= center">
                                                        <a
                                                            href="{{ route('admin.overtime.approve', ['id' => $overtime->id]) }}">
                                                            <span class="icon"><i class="fas fa-check"></i></span>
                                                        </a>
                                                        <a href="#" onclick="openRejectModal('{{ $overtime->id }}')">
                                                            <span class="icon"><i class="fas fa-times"></i></span>
                                                        </a>
                                                        <a
                                                            href="{{ route('admin.overtime.show', ['id' => $overtime->id]) }}">
                                                            <span class="icon">
                                                                <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </a>
                                                        <a
                                                            href="{{ route('admin.overtime.edit', ['id' => $overtime->id]) }}">
                                                            <span class="icon">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </span>
                                                        </a>
                                                        <div class="modal fade"
                                                            id="deleteConfirmationModal{{ $overtime->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="deleteConfirmationModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="deleteConfirmationModalLabel">Confirm
                                                                            Deletion
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancel</button>
                                                                        <button type="button" class="btn btn-danger"
                                                                            onclick="submitDeleteForm({{ $overtime->id }})">Delete</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form id="deleteForm{{ $overtime->id }}"
                                                            action="{{ route('admin.overtime.destroy', ['id' => $overtime->id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <a href="#"
                                                            onclick="event.preventDefault(); $('#deleteConfirmationModal{{ $overtime->id }}').modal('show');">
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
    <!-- Modal for Reject Note -->
    <div id="rejectModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Employee Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reject_note">Reject Reason:</label>
                            <textarea class="form-control" id="reject_note" name="reject_note" placeholder="Enter reject reason"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function submitDeleteForm(id) {
            const form = document.getElementById(`deleteForm${id}`);
            form.submit();
        }

        function openRejectModal(id) {
            $('#rejectForm').attr('action', `{{ route('admin.overtime.reject', ['id' => ':id']) }}`.replace(
                ':id', id));
            $('#rejectModal').modal('show');
        }
    </script>
@stop
