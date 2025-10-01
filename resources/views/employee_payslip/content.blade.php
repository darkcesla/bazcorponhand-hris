<div class="card-body" style="margin: 0; padding: 0;">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-10 mx-auto d-flex justify-content-between align-items-center">
                <div>
                    <img src="{{ asset('logo_bazcorp.png') }}" alt="Company Logo" style="width: 100px; height: auto;">
                </div>
                <div class="text-right" style="color: rgb(151, 33, 33);">
                    <b>Private & Confidential*</b>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 50px;">
            <div class="col-md-10 mx-auto">
                <table style="width: 100%; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 15%;">ID</td>
                        <td style="width: 35%;">: {{ $employee_payslip->employee->employee_no }}</td>
                        <td style="width: 15%;">PTKP</td>
                        <td style="width: 35%;">: TK I</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: {{ $employee_payslip->employee->firstname }} {{ $employee_payslip->employee->lastname }}</td>
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
        <div class="row" style="padding-top: 50px;">
            <div class="col-md-10 mx-auto">
                <table style="border-collapse: collapse; width: 100%; border: 2px solid #e2e2e2;">
                    <thead>
                        <tr>
                            <th colspan="2" style="width: 50%; border-bottom: 2px solid #e2e2e2; background-color: #f0f0f0;">
                                Earnings</th>
                            <th colspan="2" style="border-left: 1px solid #e2e2e2; width: 50%; border-bottom: 2px solid #e2e2e2; background-color: #f0f0f0;">
                                Deductions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $maxLength; $i++)
                            <tr>
                                <td>
                                    @if (isset($earnings[$i]->name))
                                        {{ $earnings[$i]->name }}
                                    @endif
                                </td>
                                <td class="right-align">
                                    @if (isset($earnings[$i]->amount))
                                        {{ number_format($earnings[$i]->amount, 0) }}
                                    @endif
                                </td>
                                <td style="border-left: 1px solid #e2e2e2;">
                                    @if (isset($deductions[$i]->name))
                                        {{ $deductions[$i]->name }}
                                    @endif
                                </td>
                                <td class="right-align">
                                    @if (isset($deductions[$i]->amount))
                                        {{ number_format($deductions[$i]->amount, 0) }}
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total earnings</th>
                            <th class="right-align">{{ number_format($totalEarnings, 0) }}</th>
                            <th style="border-left: 1px solid #e2e2e2;">Total deductions</th>
                            <th class="right-align">{{ number_format($totalDeductions, 0) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row" style="padding-top: 20px;">
            <div class="col-md-10 mx-auto">
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="2" style="width: 50%;"></th>
                            <th style="width: 25%;">
                                <h5><b>Take Home Pay</b></h5>
                            </th>
                            <th class="right-align" style="width: 25%;">
                                <h5><b>{{ number_format($netpay, 0) }}</b></h5>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="col-md-10 mx-auto">
                <table style="border-collapse: collapse; width: 50%;">
                    <thead>
                        <tr>
                            <th colspan="2" style="width: 100%; border-bottom: 2px solid #e2e2e2;">
                                Benefits*</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($benefits as $benefit)
                            <tr>
                                <td>{{ $benefit->name }}</td>
                                <td class="right-align">{{ number_format($benefit->amount, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th class="right-align">{{ number_format($totalBenefits, 0) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
