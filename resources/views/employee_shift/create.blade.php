@extends('layout.main')
@section('content')

<div class="content-wrapper">
    <div class="content-header"></div>
    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center mb-2">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background-color: transparent;">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.employee_shift') }}">Employee Shift</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.employee_shift.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Shift Daily</label>
                                <select name="shift_daily_id" class="form-control">
                                    @foreach ($shift_daily as $shift_daily)
                                        <option value="{{ $shift_daily->id }}">
                                            {{ $shift_daily->shift_daily_code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Start Shift Date</label>
                                <input name="date" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">End Shift Date</label>
                                <input name="end_date" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label form-label">Employee</label>
                                <div class="d-flex align-items-center">
                                    <select name="employee_id" id="employee" class="form-control">
                                        <option value="">-- Select Employee --</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" data-groups="{{ $employee->group_id }}">
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#groupModal">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-3">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
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
                    @foreach($groups as $group)
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
    function applyFilter() {
        const groupId = document.getElementById('modalGroup').value;
        filterEmployees(groupId);
        $('#groupModal').modal('hide');
    }

    function filterEmployees(groupId) {
        const employees = document.querySelectorAll('#employee option');
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
