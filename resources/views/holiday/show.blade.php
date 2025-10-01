@extends('layout.main')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-2">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background-color: transparent;">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.holiday') }}">Holiday</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Holiday Name</label>
                                <input name="holiday_name" type="text" class="form-control"
                                    value="{{ $holiday->holiday_name }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Start Date</label>
                                <input name="start_date" type="date"
                                    class="form-control"value="{{ $holiday->start_date }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">End Date</label>
                                <input name="end_date" type="date"
                                    class="form-control"value="{{ $holiday->end_date }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Holiday Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Public" name="holiday_type">
                                    <label class="form-check-label">Public</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Company" name="holiday_type"
                                        checked>
                                    <label class="form-check-label">Company</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Religion</label>
                                <input name="religion" type="text"
                                    class="form-control"value="{{ $holiday->religion }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Nationality</label>
                                <input name="nationality" type="text"
                                    class="form-control"value="{{ $holiday->nationality }}" disabled>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label" for="recur_every_year">Recur Every Year</label>
                                <select name="recur_every_year" id="recur_every_year" class="form-control" disabled>
                                    <option value="1" {{ $holiday->recur_every_year == 1 ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="0" {{ $holiday->recur_every_year == 0 ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label></label>
                                <div class=""
                                    style="d-flex justify-content-center align-items-center text-align:center">
                                    <a href="{{ route('admin.holiday.edit', ['id' => $holiday->id]) }}"
                                        class="btn btn-success">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
