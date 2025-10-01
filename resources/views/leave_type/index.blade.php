@extends('layout.main')
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
                                        <li class="breadcrumb-item active" aria-current="page">Leave Type</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.leave_type.create') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Leave Code</th>
                                            <th>Leave Name</th>
                                            <th>Leave Day Type</th>
                                            <th>Deducted Leave</th>
                                            <th>Day Count</th>
                                            <th>Eligibility Leave</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leave_type as $leave_type)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="">
                                                    <a
                                                        href="{{ route('admin.leave_type.edit', ['id' => $leave_type->id]) }}">
                                                        <span
                                                            class="js-lists-values-leave_type_code">{{ $leave_type->leave_code }}</span>
                                                    </a>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-start_time">{{ $leave_type->leave_name }}</span>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-end_time">{{ $leave_type->leave_day_type }}</span>
                                                </td>
                                                <td style="">
                                                    <span> {{ $leave_type->deducted_leave == 1 ? 'Yes' : 'No' }} </span>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-day_type">{{ $leave_type->day_count }}</span>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-flexible_shift">{{ $leave_type->eligibility_leave }}</span>
                                                </td>
                                                <td style="width: 10px;align= center">
                                                    <a
                                                        href="{{ route('admin.leave_type.show', ['id' => $leave_type->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                    </a>
                                                    <a
                                                        href="{{ route('admin.leave_type.edit', ['id' => $leave_type->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-pencil-alt"></i> <!-- Icon pensil (pencil) -->
                                                        </span>
                                                    </a>
                                                    <div class="modal fade"
                                                        id="deleteConfirmationModal{{ $leave_type->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="deleteConfirmationModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteConfirmationModalLabel">Confirm Deletion
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
                                                                        onclick="submitDeleteForm({{ $leave_type->id }})">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form id="deleteForm{{ $leave_type->id }}"
                                                        action="{{ route('admin.leave_type.destroy', ['id' => $leave_type->id]) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="#"
                                                        onclick="event.preventDefault(); $('#deleteConfirmationModal{{ $leave_type->id }}').modal('show');">
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
