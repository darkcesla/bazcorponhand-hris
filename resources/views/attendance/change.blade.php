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
                                <li class="breadcrumb-item"><a href="{{ route('admin.employee') }}">Employee Changes</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.employee.change_approval', $change->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="original_data">Original Data</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="original_data">Changed Data</label>
                                        </div>
                                    </div>
                                    @php
                                        $changedData = json_decode($change->changed_data, true);
                                    @endphp
                                    @foreach ($changedData as $key => $value)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label form-label"
                                                    for="{{ $key }}">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" class="form-control bg-white" id="{{ $key }}"
                                                    name="{{ $key }}[original]" value="{{ $employee->$key }}"
                                                    readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label form-label"
                                                    for="{{ $key }}">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" class="form-control" id="{{ $key }}"
                                                    name="{{ $key }}[original]" value="{{ $value }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" name="approval_status" value="approved" class="btn btn-success me-2">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button type="submit" name="approval_status" value="rejected" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@stop
