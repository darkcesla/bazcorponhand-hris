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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_attendance_location') }}">Employee Attendance Location</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_attendance_location.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Attandance Location</label>
                                <select name="attendance_location_id" class="form-control">
                                    @foreach ($attendanceLocation as $attendanceLocation)
                                        <option value="{{ $attendanceLocation->id }}">
                                            {{ $attendanceLocation->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Start Date</label>
                                <input name="start_date" type="date" class="form-control">
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">End Date</label>
                                <input name="end_date" type="date" class="form-control">
                            </div>
                            <!-- Available Employees List -->
                            <div class="col-md-8">
                                <label for="available-employees">Available Employees:</label>
                                <select id="available-employees" class="form-control" multiple>
                                    @foreach ($employee as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }} (ID:
                                            {{ $emp->employee_no }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Buttons for Adding/Removing -->
                            <div class="col-md-8 my-2">
                                <button type="button" id="addButton" class="btn btn-primary">Add &gt;&gt;</button>
                                <button type="button" id="removeButton" class="btn btn-danger">&lt;&lt; Remove</button>
                            </div>

                            <!-- Chosen Employees List -->
                            <div class="col-md-8">
                                <label for="chosen-employees">Chosen Employees:</label>
                                <select id="chosen-employees" name="chosen_employees[]" class="form-control" multiple>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
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
