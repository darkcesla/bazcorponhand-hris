@extends('layout.main')
@section('content')

    <div class="content-wrapper">
        <div class="content-header">
        </div>
        <section class="content">
            <div class="container-fluid px-4">
                <div class="card shadow mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-2">
                            <div class="col">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb" style="background-color: transparent;">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Employee Changes</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($changeList as $change)
                                            @php
                                                $originalData = json_decode($change->original_data, true);
                                                $name =
                                                    '(' .
                                                    $originalData['employee_no'] .
                                                    ') ' .
                                                    $originalData['firstname'] .
                                                    ' ' .
                                                    $originalData['lastname'];
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span>{{ $name }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $change->approval_status }}</span>
                                                </td>
                                                <td style="width: 10px;align= center">
                                                    <a
                                                        href="{{ route('admin.employee.change', ['id' => $change->id]) }}">
                                                        <span class="icon">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
