<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('logo_bazcorp.png') }}" type="image/x-icon">
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <title>HRIS</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/fullcalendar/main.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link href="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        th {
            text-align: center;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    @stack('scripts')

    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('logo_bazcorp.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                    <li class="nav-item">
                        <form method="POST" action="{{ route('admin.company.select') }}">
                            @csrf
                            <select name="selected_company" onchange="this.form.submit()" class="form-control">
                                <option value="0" {{ session('selected_company') == 0 ? 'selected' : '' }}>All
                                    Companies</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ session('selected_company') == $company->id ? 'selected' : '' }}>
                                        {{ $company->site }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown ml-1 ml-md-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            width="30px" height="30px" alt="User Avatar">
                        <span></span>
                        <span></span>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="fa fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fa fa-lock"></i>
                            <span>Logout</span>
                        </a>
                    </div>

                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <img src="{{ asset('logo_bazcorp_2.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">HRIS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'moderator')
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            @if (auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-database"></i>
                                        <p>
                                            Master Data
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.company') }}" class="nav-link">
                                                <i class="far fa-building nav-icon"></i>
                                                <p>Company</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.division') }}" class="nav-link">
                                                <i class="fas fa-sitemap nav-icon"></i>
                                                <p>Division</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.position') }}" class="nav-link">
                                                <i class="fas fa-project-diagram"></i>
                                                <p>Position</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.user') }}" class="nav-link">
                                                <i class="fas fa-user-lock nav-icon"></i>
                                                <p>User Account</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-address-book"></i>
                                    <p>
                                        Employee
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee') }}" class="nav-link">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Employee Data</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee_bank_account') }}" class="nav-link">
                                            <i class="fas fa-landmark nav-icon"></i>
                                            <p>Employee Bank Account</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee.change_list') }}" class="nav-link">
                                            <i class="fas fa-id-card nav-icon"></i>
                                            <p>Data Update Request</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-calendar"></i>
                                    <p>
                                        Shift
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.shift_daily') }}" class="nav-link">
                                            <i class="far fa-edit nav-icon"></i>
                                            <p>Shift Daily</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.shift_group') }}" class="nav-link">
                                            <i class="far fa-edit nav-icon"></i>
                                            <p>Shift Group</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee_shift_group') }}" class="nav-link">
                                            <i class="far fa-edit nav-icon"></i>
                                            <p>Employee Shift Group</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee_shift') }}" class="nav-link">
                                            <i class="far fa-edit nav-icon"></i>
                                            <p>Employee Shift</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-calendar"></i>
                                    <p>
                                        Leave
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.leave_type') }}" class="nav-link">
                                            <i class="far fa-clipboard nav-icon"></i>
                                            <p>Leave Type</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.mass_leave') }}" class="nav-link">
                                            <i class="fas fa-clipboard nav-icon"></i>
                                            <p>Mass Leave</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee_leave_balance') }}" class="nav-link">
                                            <i class="fas fa-tasks nav-icon"></i>
                                            <p>Employee Leave Balance</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>
                                        Attendance
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.attendance_location') }}" class="nav-link">
                                            <i class="nav-icon fas fas fa-map-marker-alt"></i>
                                            <p>Attendance Location</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee_attendance_location') }}" class="nav-link">
                                            <i class="nav-icon far fa-map"></i>
                                            <p>Employee Attendance Location</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.attendance') }}" class="nav-link">
                                            <i class="nav-icon fas fa-clock "></i>
                                            <p>
                                                Employee Attendance
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>
                                        Leave and Overtime Request
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.employee_leave_history') }}" class="nav-link">
                                            <i class="fas fa-tasks nav-icon"></i>
                                            <p>Employee Leave</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.overtime') }}" class="nav-link">
                                            <i class="fas fa-clock nav-icon"></i>
                                            <p>Employee Overtime</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @if (auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>
                                            Payroll
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.employee_payroll') }}" class="nav-link">
                                                <i class="nav-icon fas fa-money-check-alt"></i>
                                                <p>Employee Payroll</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.deduction') }}" class="nav-link">
                                                <i class="nav-icon fas fa-donate"></i>
                                                <p>Deduction</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.earning') }}" class="nav-link">
                                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                                <p>Earning</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.holiday') }}" class="nav-link">
                                        <i class="nav-icon far fa-calendar-times"></i>
                                        <p>
                                            Holiday
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.announcement') }}" class="nav-link">
                                        <i class="nav-icon 	fas fa-bullhorn"></i>
                                        <p>
                                            Announcement
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.employee_career') }}" class="nav-link">
                                        <i class="nav-icon fas fa-id-badge"></i>
                                        <p>
                                            Career
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.kpi') }}" class="nav-link">
                                        <i class="nav-icon fa fa-signal"></i>
                                        <p>
                                            KPI
                                        </p>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-address-book"></i>
                                    <p>
                                        Employee
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('profile') }}" class="nav-link">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Employee Data</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('employee_payslip') }}" class="nav-link">
                                    <i class="nav-icon fas fa-balance-scale"></i>
                                    <p>Payslip</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('overtime.slip_index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-balance-scale"></i>
                                    <p>Overtime Payslip</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-address-book"></i>
                                    <p>
                                        Attendance
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('attendance.current') }}" class="nav-link">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Today Attendance</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('attendance') }}" class="nav-link">
                                            <i class="fas fa-landmark nav-icon"></i>
                                            <p>Attendance</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('overtime') }}" class="nav-link">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Overtime</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-calendar"></i>
                                    <p>
                                        Leave
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('employee_leave_balance') }}" class="nav-link">
                                            <i class="fas fa-tasks nav-icon"></i>
                                            <p>Leave Balance</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('employee_leave_history') }}" class="nav-link">
                                            <i class="fas fa-tasks nav-icon"></i>
                                            <p>Leave History</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        @yield('importExel')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a>BazCorp</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/fullcalendar/main.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin_assets/js/demo/datatables-demo.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('lte/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('lte/dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("asset('js/style.js')").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            var googleMapsUrl = "https://maps.google.com/maps?q=" + latitude + "," + longitude + "&output=embed";
            var mapFrame = document.getElementById("mapFrame");
            mapFrame.src = googleMapsUrl;
        }

        window.onload = function() {
            console.log("Window loaded");
            getLocation();
            var selectedCompany = sessionStorage.getItem('selected_company');
        };
    </script>

    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ $errors->first() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @yield('scripts')
    @stack('scripts_bottom')
</body>

</html>
