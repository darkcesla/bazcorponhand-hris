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
                                <li class="breadcrumb-item"><a href="{{ route('admin.holiday') }}">Holiday</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.holiday.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Holiday Name</label>
                                    <input name="holiday_name" type="text" class="form-control" >
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Start Date</label>
                                    <input name="start_date" type="date" class="form-control" >
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">End Date</label>
                                    <input name="end_date" type="date" class="form-control" >
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Holiday Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Public"
                                            name="holiday_type">
                                        <label class="form-check-label">Public</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Company"
                                            name="holiday_type" checked>
                                        <label class="form-check-label">Company</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Religion</label>
                                    <select name="religion" class="form-control">
                                        <option value="No Religion">No Religion</option>
                                        <option value="Christianity">Christianity</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Hinduism">Hinduism</option>
                                        <option value="Buddhism">Buddhism</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Nationality</label>
                                    <input name="nationality" type="text" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Recure Every Year</label>
                                    <div class="form-check">
                                        <input type="hidden" name="recur_every_year" value="0">
                                        <input id="recur_every_year"  name="recur_every_year" type="checkbox" class="form-check-input" value="1">
                                        <label class="form-check-label" for="exampleCheck1">Yes</label>
                                    </div>
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

@stop
