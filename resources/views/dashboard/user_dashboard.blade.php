@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Schedule section -->
                    <section class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Weekly Schedule
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body schedule-body" style="max-height: 300px; overflow-y: auto;">
                                <div class="row">
                                    @php
                                        $startOfWeek = (new \DateTime())->modify('monday this week')->format('Y-m-d');
                                        $daysOfWeek = [
                                            'Monday',
                                            'Tuesday',
                                            'Wednesday',
                                            'Thursday',
                                            'Friday',
                                            'Saturday',
                                            'Sunday',
                                        ];
                                        $currentDate = (new \DateTime())->format('Y-m-d');
                                    @endphp

                                    @foreach ($daysOfWeek as $index => $day)
                                        @php
                                            $date = (new \DateTime($startOfWeek))
                                                ->modify("+{$index} days")
                                                ->format('Y-m-d');
                                            $shift = $weeklyShift->firstWhere('date', $date);
                                        @endphp

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                            <div class="card {{ $date == $currentDate ? 'border-warning' : '' }} schedule-item"
                                                id="{{ $date == $currentDate ? 'today-schedule' : '' }}">
                                                <div
                                                    class="card-header p-2 {{ $date == $currentDate ? 'bg-warning' : '' }}">
                                                    <h6 class="card-title mb-0">{{ $day }}</h6>
                                                </div>
                                                <div class="card-body p-2">
                                                    @if ($shift)
                                                        <p class="mb-1" style="font-size: medium;">
                                                            {{ $shift->shift_daily->shift_daily_code }}
                                                        </p>
                                                        <p style="font-size: small;">
                                                            {{ $shift->shift_daily->start_time }} -
                                                            {{ $shift->shift_daily->end_time }}</p>
                                                    @else
                                                        <p style="font-size: medium;">No shift</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn mr-1"></i>
                                    Notification
                                    @if ($notifCount > 0)
                                        <span class="badge badge-danger ml-2">{{ $notifCount }}</span>
                                    @endif
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                <table class="table">
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <a
                                                            href="{{ route('notification.show', ['id' => $notification->id]) }}">{{ $notification->title }}</a>
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
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Add this script at the bottom of the page -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const todaySchedule = document.getElementById('today-schedule');
            if (todaySchedule) {
                todaySchedule.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    </script>
@endsection
