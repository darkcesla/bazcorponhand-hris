<div class="card-body" style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-10 mx-auto d-flex justify-content-between align-items-center py-3">
                <div>
                    <img src="{{ asset('logo_bazcorp.png') }}" alt="Company Logo" style="width: 100px; height: auto;">
                </div>
                <div class="text-right" style="color: rgb(151, 33, 33); font-size: 1.2em;">
                    <strong>Private & Confidential*</strong>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 50px;">
            <div class="col-md-10 mx-auto">
                <table style="width: 100%; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 15%;">ID</td>
                        <td style="width: 35%;">: {{ $overtimes->employee->employee_no }}</td>
                        <td style="width: 15%;">PTKP</td>
                        <td style="width: 35%;">: TK I</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: {{ $overtimes->employee->firstname }} {{ $overtimes->employee->lastname }}</td>
                        <td>NPWP</td>
                        <td>: 123212145123</td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td>: Kepala Bagian</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row" style="padding-top: 30px;">
            <div class="col-md-10 mx-auto">
                <table style="border-collapse: collapse; width: 100%; border: 2px solid #e2e2e2; text-align: left;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="width: 50%; border-bottom: 2px solid #e2e2e2; background-color: #f0f0f0;">
                                Total Overtime</th>
                            <th
                                style="border-left: 1px solid #e2e2e2; width: 50%; border-bottom: 2px solid #e2e2e2; background-color: #f0f0f0;">
                                Total Salary
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 8px;">{{ $totalHour }} (Hour)</td>
                            <td style="border-left: 1px solid #e2e2e2; padding: 8px; text-align: right;">{{ number_format($totalSalary, 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="padding-top: 20px;">
            <div class="col-md-10 mx-auto">
            </div>
        </div>
    </div>
</div>
