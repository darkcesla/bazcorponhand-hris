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
                                        <li class="breadcrumb-item active" aria-current="page">Shift Group</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.shift_group.create') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>

                                        <tr>
                                            <th>No.</th>
                                            <th>Group Code</th>
                                            <th>Group Name</th>
                                            <th>Total Days</th>
                                            <th>Start Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shift_groups as $shift_group)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="">
                                                    <a
                                                        href="{{ route('admin.shift_group.edit', ['id' => $shift_group->id]) }}">
                                                        <span
                                                            class="js-lists-values-shift_group_code">{{ $shift_group->group_code }}</span>
                                                    </a>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-start_time">{{ $shift_group->group_name }}</span>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-start_time">{{ $shift_group->total_days }}</span>
                                                </td>
                                                <td style="">
                                                    <span
                                                        class="js-lists-values-start_time">{{ $shift_group->start_date }}</span>
                                                </td>
                                                <td style="width: 10px;align= center">
                                                    <a
                                                        href="{{ route('admin.shift_group.show', ['id' => $shift_group->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                    </a>
                                                    <a
                                                        href="{{ route('admin.shift_group.edit', ['id' => $shift_group->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="deleteConfirmationModal{{ $shift_group->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
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
                                                                        onclick="submitDeleteForm({{ $shift_group->id }})">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form id="deleteForm{{ $shift_group->id }}"
                                                        action="{{ route('admin.shift_group.destroy', ['id' => $shift_group->id]) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="#"
                                                        onclick="event.preventDefault(); $('#deleteConfirmationModal{{ $shift_group->id }}').modal('show');">
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
