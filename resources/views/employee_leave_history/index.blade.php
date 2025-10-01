@extends('layout.main')

@section('title', 'Employee Leave History')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
    </div>
    <section class="content">
        <div class="container-fluid px-4">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center mb-2">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background-color: transparent;">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Employee Leave History</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.employee_leave_history.create') }}" class="btn btn-success"
                            style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee_leave_history as $history)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $history->employee->firstname }} {{ $history->employee->lastname }}</td>
                                    <td>{{ $history->leave_type->leave_name }}</td>
                                    <td>{{ $history->start_date }}</td>
                                    <td>{{ $history->end_date }}</td>
                                    <td>{{ $history->approval_status }}</td>
                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                                    <td>
                                        <a href="{{ route('admin.employee_leave_history.approve', ['id' => $history->id]) }}">
                                            <span class="icon"><i class="fas fa-check"></i></span>
                                        </a>
                                        <a href="#" onclick="openRejectModal('{{ $history->id }}')">
                                            <span class="icon"><i class="fas fa-times"></i></span>
                                        </a>
                                        <a href="{{ route('admin.employee_leave_history.show', ['id' => $history->id]) }}">
                                            <span class="icon"><i class="fas fa-info-circle"></i></span>
                                        </a>
                                        <a href="{{ route('admin.employee_leave_history.edit', ['id' => $history->id]) }}">
                                            <span class="icon"><i class="fas fa-pencil-alt"></i></span>
                                        </a>
                                        <a href="#" onclick="event.preventDefault(); submitDeleteForm('{{ $history->id }}');">
                                            <span class="icon"><i class="fas fa-trash-alt"></i></span>
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

@endsection

@section('scripts')
<script>
    function submitDeleteForm(id) {
        const form = document.getElementById(`deleteForm${id}`);
        form.submit();
    }

    function openRejectModal(id) {
        $('#rejectForm').attr('action', `{{ route('admin.employee_leave_history.reject', ['id' => ':id']) }}`.replace(':id', id));
        $('#rejectModal').modal('show');
    }
</script>
@endsection