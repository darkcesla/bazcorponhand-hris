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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_shift_group') }}">Shift Daily Group</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_shift_group.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Shift Group</label>
                                    <select name="shift_group_id" class="form-control">
                                        @foreach ($shift_groups as $shift_group)
                                            <option value="{{ $shift_group->id }}">{{ $shift_group->group_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Start Shift Date</label>
                                    <input name="start_shift_date" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">End Shift Date</label>
                                    <input name="end_date" type="date" class="form-control">
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Start Shift Daily</label>
                                    <select name="shift_group_id" class="form-control">
                                        @foreach ($shift_groups as $shift_group)
                                            <option value="{{ $shift_group->id }}">{{ $shift_group->group_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="row">
                                <!-- Available Employees List -->
                                <div class="col-md-6">
                                    <label for="available-employees">Available Employees:</label>
                                    <select id="available-employees" class="form-control" multiple>
                                        @foreach ($employees as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->name }} (ID:
                                                {{ $emp->employee_no }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Buttons for Adding/Removing -->
                                <div class="col-md-6 my-2">
                                    <button type="button" id="addButton" class="btn btn-primary">Add &gt;&gt;</button>
                                    <button type="button" id="removeButton" class="btn btn-danger">&lt;&lt; Remove</button>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Chosen Employees List -->
                                <div class="col-md-6">
                                    <label for="chosen-employees">Chosen Employees:</label>
                                    <select id="chosen-employees" name="chosen_employees[]" class="form-control" multiple>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
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
        // Function to move selected items from available-employees to chosen-employees
        document.getElementById('addButton').addEventListener('click', function() {
            var availableEmployees = document.getElementById('available-employees');
            var chosenEmployees = document.getElementById('chosen-employees');

            for (var i = 0; i < availableEmployees.options.length; i++) {
                var option = availableEmployees.options[i];
                if (option.selected) {
                    chosenEmployees.appendChild(option);
                    i--; // Adjust index as we're removing elements from available-employees
                }
            }
        });

        // Function to move selected items from chosen-employees back to available-employees
        document.getElementById('removeButton').addEventListener('click', function() {
            var availableEmployees = document.getElementById('available-employees');
            var chosenEmployees = document.getElementById('chosen-employees');

            for (var i = 0; i < chosenEmployees.options.length; i++) {
                var option = chosenEmployees.options[i];
                if (option.selected) {
                    availableEmployees.appendChild(option);
                    i--; // Adjust index as we're removing elements from chosen-employees
                }
            }
        });
    </script>
@stop
