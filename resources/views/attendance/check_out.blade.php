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
                    <div class="col-md-8">
                        <div id="my_camera"></div><br>
                        <button style="d-flex justify-content-center align-items-center text-align:center"
                            class="btn btn-success" onclick="takeSnapshot()">Capture Snapshot</button><br>
                        <div id="results"></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.checkout_process', ['id' => $attendance->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Attendance Location</label>
                                    <select name="attendance_location_id" class="form-control">
                                        @foreach ($attendanceLocation as $location)
                                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" id="latitude" name="check_out_latitude">
                                    <input type="hidden" id="longitude" name="check_out_longitude">
                                </div>
                                <div class="col-md-8">
                                    <label>Your Current Location</label><br><br>
                                    <iframe id="mapFrame" width="600" height="450" frameborder="0" scrolling="no"
                                        marginheight="0" marginwidth="0" style="border: 1px solid black"></iframe>
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
    <script>
        Webcam.set({
            width: 470,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');

        function takeSnapshot() {
            Webcam.snap(function(data_uri) {
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                document.getElementById('selfie').value = data_uri;
            });
            Webcam.reset();
        }
    </script>

@stop
