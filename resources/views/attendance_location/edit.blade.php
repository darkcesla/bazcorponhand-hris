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
                                <li class="breadcrumb-item"><a href="/admin/attendance-location">Attendance Location</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attendance_location.update', ['id' => $attendance_location->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Location Code<span style="color: red;"> *</span></label>
                                    <input name="location_code" value="{{ $attendance_location->location_code }}"
                                        type="text" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Location Name<span style="color: red;"> *</span></label>
                                    <input name="location_name" value="{{ $attendance_location->location_name }}"
                                        type="text" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Location Address</label>
                                    <input name="location_address" value="{{ $attendance_location->location_address }}"
                                        type="text" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">City</label>
                                    <input name="city" value="{{ $attendance_location->city }}" type="text"
                                        class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">State/Province</label>
                                    <input name="province" value="{{ $attendance_location->province }}" type="text"
                                        class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Country</label>
                                    <input name="country" value="{{ $attendance_location->country }}" type="text"
                                        class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Maximum Radius<span style="color: red;"> *</span></label>
                                    <div class="input-group">
                                        <input name="max_radius" type="number" class="form-control" value="{{ $attendance_location->max_radius }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">meter</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Latitude<span style="color: red;"> *</span></label>
                                    <input name="latitude" value="{{ $attendance_location->latitude }}" type="number"
                                        class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Longitude<span style="color: red;"> *</span></label>
                                    <input name="longitude" value="{{ $attendance_location->longitude }}" type="number"
                                        class="form-control">
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
