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
                                <li class="breadcrumb-item"><a href="{{ route('admin.attendance') }}">Attendance</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attendance.export') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
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
                                <div class="col-md-3">
                                    <label for="start_date" class="col-form-label form-label">Start Date:</label>
                                    <input type="date" id="start_date" name="start_date"
                                        value="{{ request('start_date') }}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="col-form-label form-label">End Date:</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status" class="col-form-label form-label">Attendance Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="-1">All</option>
                                        <option value="1">Present</option>
                                        <option value="2">Late</option>
                                        <option value="3">Absent</option>
                                        <option value="4">On Leave</option>
                                        <option value="5">Sick</option>
                                        <option value="6">Permission</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label></label>
                                    <div class=""
                                        style="d-flex justify-content-center align-items-center text-align:center">
                                        <button type="submit" class="btn btn-success">Create Report</button>
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
