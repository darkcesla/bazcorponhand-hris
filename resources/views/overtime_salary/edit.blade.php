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
                                <li class="breadcrumb-item"><a href="/admin/overtime-salary">Overtime Salary</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.overtime_salary.update', ['id' => $overtime_salary->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Code</label>
                                    <input name="code" type="text" class="form-control"
                                        value="{{ $overtime_salary->code }}">
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label form-label">Company</label>
                                    <select name="company_id" class="form-control">
                                        {{-- @foreach (session('companies') as $id => $name)
                                            <option value="{{ $overtime_salary->company_id }}">{{ $overtime_salary->company->site }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label form-label">Salary Per Hour</label>
                                <input name="salary_per_hour" type="text" class="form-control"
                                    value="{{ $overtime_salary->salary_per_hour }}">
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
