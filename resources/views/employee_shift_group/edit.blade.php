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
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee_shift_group.update', ['id' => $employee_shift_group->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Shift Group</label>
                                    <select name="shift_group_id" class="form-control">
                                        @foreach ($shift_groups as $shift_group)
                                            <option value="{{ $shift_group->id }}"
                                                {{ $employee_shift_group->shift_group_id == $shift_group->id ? 'selected' : '' }}>
                                                {{ $shift_group->group_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Start Shift Date</label>
                                    <input name="start_shift_date" type="date" class="form-control"
                                        value="{{ $employee_shift_group->start_shift_date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">End Shift Date</label>
                                    <input name="end_date" type="date" class="form-control"
                                        value="{{ $employee_shift_group->end_date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Employee</label>
                                    <input name="employee_id" type="text" class="form-control"
                                        value="{{ $employee_shift_group->employee->firstname }} {{ $employee_shift_group->employee->lastname }}"
                                        disabled>
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
@stop
