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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_career') }}">Employee
                                        Carrer</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_career.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="employee_id" class="col-form-label form-label">Employee</label>
                                    <select id="employee_id" name="employee_id" class="form-control" required>
                                        @foreach ($employee as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->name }} (ID:
                                                {{ $emp->employee_no }})</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="transition_number" class="col-form-label form-label">Transition
                                        Number</label>
                                    <input id="transition_number" name="transition_number" type="text"
                                        class="form-control" value="{{ old('transition_number') }}" required>
                                    @error('transition_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="file" class="col-form-label form-label">Letter</label>
                                    <input id="file" type="file" name="file" class="form-control-file">
                                    @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="transition_type" class="col-form-label form-label">Transition Type</label>
                                    <select id="transition_type" name="transition_type" class="form-control" required>
                                        <option value="Join" {{ old('transition_type') == 'Join' ? 'selected' : '' }}>
                                            Join
                                        </option>
                                        <option value="Mutation"
                                            {{ old('transition_type') == 'Mutation' ? 'selected' : '' }}>
                                            Mutation</option>
                                        <option value="Termination"
                                            {{ old('transition_type') == 'Termination' ? 'selected' : '' }}>Termination
                                        </option>
                                    </select>
                                    @error('transition_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="join_date" class="col-form-label form-label">Join Date</label>
                                    <input id="join_date" name="join_date" type="date" class="form-control"
                                        value="{{ old('join_date') }}">
                                    @error('join_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="termination_type" class="col-form-label form-label">Termination Type</label>
                                    <select id="termination_type" name="termination_type" class="form-control">
                                        <option value="" {{ old('termination_type') == '' ? 'selected' : '' }}>-
                                        </option>
                                        <option value="Resign" {{ old('termination_type') == 'Resign' ? 'selected' : '' }}>
                                            Resign</option>
                                        <option value="Fired" {{ old('termination_type') == 'Fired' ? 'selected' : '' }}>
                                            Fired</option>
                                    </select>
                                    @error('termination_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="date" class="col-form-label form-label">Date</label>
                                    <input id="date" name="date" type="date" class="form-control"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="employment_type" class="col-form-label form-label">Employment Type</label>
                                    <select id="employment_type" name="employment_type" class="form-control" required>
                                        <option value="permanent"
                                            {{ old('employment_type') == 'permanent' ? 'selected' : '' }}>Permanent
                                        </option>
                                        <option value="contract"
                                            {{ old('employment_type') == 'contract' ? 'selected' : '' }}>
                                            Contract</option>
                                    </select>
                                    @error('employment_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contract_start_date" class="col-form-label form-label">Contract Start
                                        Date</label>
                                    <input id="contract_start_date" name="contract_start_date" type="date"
                                        class="form-control" value="{{ old('contract_start_date') }}">
                                    @error('contract_start_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contract_end_date" class="col-form-label form-label">Contract End
                                        Date</label>
                                    <input id="contract_end_date" name="contract_end_date" type="date"
                                        class="form-control" value="{{ old('contract_end_date') }}">
                                    @error('contract_end_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="position" class="col-form-label form-label">Position</label>
                                    <input id="position" name="position" type="text" class="form-control"
                                        value="{{ old('position') }}">
                                    @error('position')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="department" class="col-form-label form-label">Department</label>
                                    <input id="department" name="department" type="text" class="form-control"
                                        value="{{ old('department') }}">
                                    @error('department')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    <div class="d-flex justify-content-center align-items-center text-align:center">
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
