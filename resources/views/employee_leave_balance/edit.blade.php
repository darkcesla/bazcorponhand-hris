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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee_leave_balance') }}">Employee Leave</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_leave_balance.update', ['id' => $employee_leave_balance->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Type</label>
                                    <select name="leave_type_id" class="form-control">
                                        @foreach ($leave_type as $type)
                                            <option value="{{ $type->id }}"
                                                @if ($type->id == $employee_leave_balance->leave_type_id) selected @endif>
                                                {{ $type->leave_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-8">
                                    <label class="col-form-label form-label">Leave Status</label>
                                    <select name="leave_status" class="form-control">
                                        <option value="{{ $employee_leave_balance->leave_status }}">
                                            {{ $employee_leave_balance->leave_status }}</option>
                                    </select>
                                </div> --}}
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Employee</label>
                                    <input name="employee_id" type="text" class="form-control"
                                        value="{{ $employee_leave_balance->employee->firstname }} {{ $employee_leave_balance->employee->lastname }}"
                                        disabled>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                        data-target="#groupModal">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Balance</label>
                                    <input name="balance" type="text" class="form-control"
                                        value="{{ $employee_leave_balance->balance }}">
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
        const checkbox = document.getElementById('flex_check');
        const hiddenInput = document.querySelector('input[name="flexible_shift"]');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                hiddenInput.value = 1; // Set value to 1 when checked
            } else {
                hiddenInput.value = 0; // Set value to 0 when unchecked
            }
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
