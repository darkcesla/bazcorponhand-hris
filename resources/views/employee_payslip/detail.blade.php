@extends('layout.main')

@section('title', 'Employe')

@section('content')
    <style>
        th,
        td {
            text-align: left;
            padding: 8px;
        }

        .right-align {
            text-align: right;
        }

        tfoot th {
            border-top: 2px solid #e2e2e2;
            /* Add a left border to td elements that come after another td element */
        }
    </style>
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
                                        <li class="breadcrumb-item active" aria-current="page">Payslip</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('employee_payslip.generate_pdf') }}" class="btn btn-success"
                                    style="padding: 0.1rem 0.5rem;"><i class="fa fa-download"></i></a>
                            </div>
                        </div>
                        @include('employee_payslip.content')
                    </div>
                </div>
        </section>
    </div>
@stop
