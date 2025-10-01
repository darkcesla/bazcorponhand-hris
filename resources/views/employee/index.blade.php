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
                                        <li class="breadcrumb-item active" aria-current="page">Employee</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.employee.create') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#importModal" style="padding: 0.1rem 0.5rem;"><i
                                        class="fas fa-file-excel"></i></button>
                                <div class="modal fade" id="importModal" tabindex="-1" role="dialog"
                                    aria-labelledby="importModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.employee.import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="fileInput">Pilih File</label>
                                                        <input type="file" class="form-control" id="fileInput"
                                                            name="file">
                                                        @error('file')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.download', ['filename' => 'employee_template.xlsx']) }}">Download Template</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Employee No.</th>
                                            <th>Name</th>
                                            <th>Site</th>
                                            <th>Division</th>
                                            <th>Position</th>
                                            @if (auth()->user()->role === 'admin')
                                                <th>Action</th>
                                            @endif

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employee as $employee)
                                            <tr>
                                                <td>
                                                    <span>{{ $employee->employee_no }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->firstname }} {{ $employee->lastname }}</span>
                                                </td>
                                                <td>
                                                    <span style="color: {{ $employee->company ? 'black' : 'red' }}">
                                                        {{ $employee->company ? $employee->company->site : 'Site not found or removed' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->position->name ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->position->division->name ?? '' }}</span>
                                                </td>
                                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                                                    <td style="width: 10px;align= center">
                                                        <a
                                                            href="{{ route('admin.employee.show', ['id' => $employee->id]) }}">
                                                            <span class="icon">
                                                                <i class="fas fa-info-circle"></i>
                                                            </span>
                                                        </a>
                                                        <a
                                                            href="{{ route('admin.employee.edit', ['id' => $employee->id]) }}">
                                                            <span class="icon">
                                                                <i class="fas fa-pencil-alt"></i>
                                                                <!-- Icon pensil (pencil) -->
                                                            </span>
                                                        </a>
                                                        <!-- Confirmation Modal -->
                                                        <div class="modal fade"
                                                            id="deleteConfirmationModal{{ $employee->id }}" tabindex="-1"
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
                                                                            onclick="submitDeleteForm({{ $employee->id }})">Delete</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form id="deleteForm{{ $employee->id }}"
                                                            action="{{ route('admin.employee.destroy', ['id' => $employee->id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <a href="#"
                                                            onclick="event.preventDefault(); $('#deleteConfirmationModal{{ $employee->id }}').modal('show');">
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
    <script>
        function submitDeleteForm(id) {
            const form = document.getElementById(`deleteForm${id}`);
            form.submit();
        }
    </script>
@stop
