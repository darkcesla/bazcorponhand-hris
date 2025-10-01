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
                                <li class="breadcrumb-item"><a href="{{ route('admin.mass_leave') }}">Mass Leave</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mass_leave.update', ['id' => $mass_leave->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Name</label>
                                    <input name="mass_leave_name" type="text" class="form-control"
                                        value={{ $mass_leave->mass_leave_name }}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Type</label>
                                    <select name="leave_type_id" class="form-control">
                                        @foreach ($leave_type as $leave_type)
                                            <option value="{{ $leave_type->id }}"
                                                {{ $mass_leave->leave_type_id == $leave_type->id ? 'selected' : '' }}>
                                                {{ $leave_type->leave_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Start Date</label>
                                    <input name="start_date" type="date" class="form-control"
                                        value={{ $mass_leave->start_date }}>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">End Date</label>
                                    <input name="end_date" type="date" class="form-control"
                                        value={{ $mass_leave->end_date }}>
                                </div>
                                <!-- Available Employees List -->

                                <div class="col-md-8">
                                    <label for="available-employees">Available Employees:</label>
                                    <select id="available-employees" class="form-control" multiple>
                                        @foreach ($employees as $emp)
                                            <option value="{{ $emp->id }}" data-groups="{{ $emp->group_id }}">
                                                {{ $emp->name }} (ID:
                                                {{ $emp->employee_no }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Buttons for Adding/Removing -->
                                <div class="col-md-8 my-2">
                                    <button type="button" id="addButton" class="btn btn-primary">Add &gt;&gt;</button>
                                    <button type="button" id="removeButton" class="btn btn-danger">&lt;&lt; Remove</button>
                                    <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                        data-target="#groupModal">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>

                                <input type="hidden" name="removed_ids" id="removed_ids" value="">
                                <div class="col-md-8">
                                    <label for="chosen-employees">Chosen Employees:</label>
                                    <select id="chosen-employees" name="chosen_employees[]" class="form-control" multiple>
                                        @foreach ($chosen_employee as $emp)
                                            <option value="{{ $emp->id }}"
                                                @if (in_array($emp->id, old('chosen_employees', []))) selected @endif>
                                                {{ $emp->employee->firstname }} {{ $emp->employee->lastname }} (ID:
                                                {{ $emp->employee->employee_no }})
                                            </option>
                                        @endforeach
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
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groupModalLabel">Select Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="group">Select Group:</label>
                    <select id="modalGroup" class="form-control">
                        <option value="">--Select Group--</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="applyFilter()">Apply Filter</button>
                </div>
            </div>
        </div>
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
            var removedIds = [];

            for (var i = 0; i < chosenEmployees.options.length; i++) {
                var option = chosenEmployees.options[i];
                if (option.selected) {
                    removedIds.push(option.value);
                    availableEmployees.appendChild(option);
                    i--; // Adjust index as we're removing elements from chosen-employees
                }
            }
            var removedIdsString = removedIds.join(',');
            document.getElementById('removed_ids').value = removedIdsString;
        });

        function applyFilter() {
            const groupId = document.getElementById('modalGroup').value;
            filterEmployees(groupId);
            $('#groupModal').modal('hide');
        }

        function filterEmployees(groupId) {
            const employees = document.querySelectorAll('#available-employees option');
            employees.forEach(employee => {
                const employeeGroup = employee.getAttribute('data-groups');
                if (groupId == "" || employeeGroup == groupId) {
                    employee.style.display = 'block';
                } else {
                    employee.style.display = 'none';
                }
            });
        }
    </script>

@stop
