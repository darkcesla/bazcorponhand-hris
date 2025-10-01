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
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attendance.update', ['id' => $attendance->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Attendance Location</label>
                                    <select name="attendance_location_id" class="form-control">
                                        @foreach ($attendanceLocation as $location)
                                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Date</label>
                                    <input name="date" value="{{ $attendance->date }}" type="date"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Check In</label>
                                    <input name="check_in" value="{{ $attendance->check_in }}" type="time"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Check Out</label>
                                    <input name="check_out" value="{{ $attendance->check_out }}" type="time"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status" class="col-form-label form-label">Attendance Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $attendance->status == '0' ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ $attendance->status == '1' ? 'selected' : '' }}>Present</option>
                                        <option value="2" {{ $attendance->status == '2' ? 'selected' : '' }}>Late</option>
                                        <option value="3" {{ $attendance->status == '3' ? 'selected' : '' }}>Absent</option>
                                        <option value="4" {{ $attendance->status == '4' ? 'selected' : '' }}>On Leave</option>
                                        <option value="5" {{ $attendance->status == '5' ? 'selected' : '' }}>Sick</option>
                                        <option value="6" {{ $attendance->status == '6' ? 'selected' : '' }}>Permission</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
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
        const checkbox = document.getElementById('flex_check');
        const hiddenInput = document.querySelector('input[name="flexible_shift"]');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                hiddenInput.value = 1; // Set value to 1 when checked
            } else {
                hiddenInput.value = 0; // Set value to 0 when unchecked
            }
        });
    </script>

@stop
