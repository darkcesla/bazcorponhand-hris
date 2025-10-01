@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-4">
                        <div class="card" style="height: 95%;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn mr-1"></i>
                                    Expired Contract
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                                <table class="table">
                                    <tbody>
                                        <!-- Dummy data (replace with actual announcements) -->
                                        @foreach ($expiredContract as $contract)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <p>{{ $contract->employee->firstname }}
                                                            {{ $contract->employee->lastname }}</p>
                                                    </div>
                                                    <div style="font-size: smaller; color: #666;">
                                                        {{ $contract->end_date }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-4">
                        <div class="card" style="height: 95%;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn mr-1"></i>
                                    Announcement
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                                <table class="table">
                                    <tbody>
                                        <!-- Dummy data (replace with actual announcements) -->
                                        @foreach ($announcementData as $announcement)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <a
                                                            href="{{ route('admin.announcement.show', ['id' => $announcement->id]) }}">{{ $announcement->title }}</a>
                                                    </div>
                                                    <div style="font-size: smaller; color: #666;">
                                                        {{ $announcement->created_at }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-4">
                        <div class="card" style="height: 95%;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bell mr-1"></i>
                                    Notification
                                    @if ($notifCount > 0)
                                        <span class="badge badge-danger ml-2">{{ $notifCount }}</span>
                                    @endif
                                </h3>
                            </div>
                            <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                                <table class="table">
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('admin.notification.show', $notification->id) }}">{{ $notification->title }}</a>
                                                        @if (!$notification->read_at)
                                                            <span class="badge badge-danger ml-2">New</span>
                                                        @endif
                                                    </div>
                                                    <div style="font-size: smaller; color: #666;">
                                                        {{ $notification->created_at }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                    </section>
                </div>
                <div class="row">
                    <section class="col-lg-4">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Employee Headcount
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body" style="height: 290px; position: relative;">
                                @if ($ratio->isEmpty())
                                    <div
                                        style="height: 250px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                        <p>No data available</p>
                                    </div>
                                @else
                                    <div class="chart-responsive">
                                        <p>Total: {{ $total }}</p>
                                        <canvas id="pieChart" height="100%"></canvas>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-5">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Employee Attendance Issue
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body" style="max-height: 300px;">
                                <div style="height: 250px;">
                                    <div class="chart-responsive" style="height: 100%;">
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @php
        $genders = [];
        $counts = [];
        foreach ($ratio as $data) {
            $genders[] = $data->gender;
            $counts[] = $data->count;
        }
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (!$ratio->isEmpty())
                const data = {
                    labels: {!! json_encode($genders) !!},
                    datasets: [{
                        data: {!! json_encode($counts) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)', // Red (text-danger)
                            'rgba(75, 192, 192, 0.7)', // Green (text-success)
                        ]
                    }]
                };

                // Options for the pie chart
                const options = {
                    responsive: true,
                    maintainAspectRatio: false
                };

                // Get the context of the canvas element and create the pie chart
                const ctx = document.getElementById('pieChart').getContext('2d');
                const pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: options
                });
            @endif

            const attendanceIssues = @json($attendanceIssues);

            // Extract month names and attendance counts from the data
            const months = attendanceIssues.map(issue => issue.month);
            const absentCounts = attendanceIssues.map(issue => issue.status[0] ?? 0);
            const lateCounts = attendanceIssues.map(issue => issue.status[2] ?? 0);

            // Data for the bar chart
            const data2 = {
                labels: months,
                datasets: [{
                    label: "Absent Count",
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                    data: absentCounts
                }, {
                    label: "Late Count",
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                    data: lateCounts
                }]
            };

            // Bar chart options
            const options2 = {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            // Get the canvas element and create the bar chart
            const ctx2 = document.getElementById('barChart').getContext('2d');
            const barChart = new Chart(ctx2, {
                type: 'bar',
                data: data2,
                options: options2
            });
        });
    </script>
@endsection
