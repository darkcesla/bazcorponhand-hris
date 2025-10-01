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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_carrer') }}">Employee Carrer</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_career.update', ['id' => $employee_career->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Employee</label>
                                    <select id="employee_id" name="employee_id" class="form-control" disabled>
                                        <option value="{{ $employee_career->employee_id }}">
                                            {{ $employee_career->employee->firstname }}
                                            {{ $employee_career->employee->lastname }}(ID:
                                            {{ $employee_career->employee->employee_no }})</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Transition Number</label>
                                    <input name="transition_number" type="text" class="form-control"
                                        value="{{ $employee_career->transition_number }}">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Letter</label>
                                    <input type="file" name="file" class="form-control-file">
                                    @if ($employee_career->letter)
                                        <div>
                                            <a href="{{ Storage::url($employee_career->letter) }}" target="_blank">View
                                                Current
                                                Letter</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Transition Type</label>
                                    <select id="transition_type" name="transition_type" class="form-control">
                                        <option value="Termination">Termination</option>
                                        <option value="Mutation">Mutation</option>
                                        <option value="Join">Join</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Termination Type</label>
                                    <select id="termination_type" name="termination_type" class="form-control">
                                        <option value="">-</option>
                                        <option value="Resign">Resign</option>
                                        <option value="Cut Off">Cut Off</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Date</label>
                                    <input name="date" type="date"
                                        class="form-control"value="{{ $employee_career->date }}">
                                </div>
                                <div class="col-md-8">
                                    <label></label>
                                    <div class=""
                                        style="d-flex justify-content-center align-items-center text-align:center">
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
    <script>
        const checkbox = document.getElementById('flex_check');
        const hiddenInput = document.querySelector('input[name="flexible_shift"]');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                hiddenInput.value = 1; // Set value to 1 when checked
            } else {
                hiddenInput.value = 0; // Set value to 0 when unchecked
            }
        });
    </script>

@stop
