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
                                <li class="breadcrumb-item"><a href="/admin/user">user</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Name</label>
                                    <input name="name" type="text" class="form-control" value="{{ $user->name }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Email</label>
                                    <input name="email" type="text" class="form-control" value="{{ $user->email }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">New Password</label>
                                    <div class="input-group">
                                        <input name="password" type="password" placeholder="Enter password"
                                            class="form-control" id="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label form-label">Repeat New Password</label>
                                    <div class="input-group">
                                        <input name="password2" type="password" placeholder="Repeat password"
                                            class="form-control" id="password2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-password2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $(document).ready(function() {
            $('#toggle-password').click(function() {
                togglePasswordVisibility($('#password'), $(this));
            });

            $('#toggle-password2').click(function() {
                togglePasswordVisibility($('#password2'), $(this));
            });

            function togglePasswordVisibility(passwordField, toggleButton) {
                const passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    toggleButton.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    toggleButton.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            }
        });
    </script>

@stop
