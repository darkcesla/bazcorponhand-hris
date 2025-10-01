@extends('layout.main')

@section('title', 'Employe')

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
                                        <li class="breadcrumb-item"><a href="{{ route('admin.shift_group') }}">Shift Group</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid px-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Group Code</label>
                                        <input name="group_code" value="{{ $shift_group->group_code }}" type="text"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Group Name</label>
                                        <input name="group_name" value="{{ $shift_group->group_name }}" type="text"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="col-form-label form-label">Total Days</label>
                                        <input name="total_days" value="{{ $shift_group->total_days }}" type="text"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Tabel Shift</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Days</th>
                                                        <th>Shift Code</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($shiftDetail as $shiftDetail)
                                                       
                                                        <tr>
                                                            <td style="">
                                                                <span
                                                                    class="js-lists-values-start_time">{{ $shiftDetail->day_order }}</span>
                                                            </td>
                                                            <td style="">
                                                                <span
                                                                    class="js-lists-values-start_time">{{ $shiftDetail->shift_daily_id }}</span>
                                                            </td>
                                                            <td style="">
                                                                <span
                                                                    class="js-lists-values-start_time">Start - End: {{ $shiftDetail->shiftDaily->start_time }} - {{ $shiftDetail->shiftDaily->end_time }}</span>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
