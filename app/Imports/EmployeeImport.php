<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\EmployeePayroll;


class EmployeeImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {
                $data['company_id'] = !empty($row[1]) ? $row[1] : '';
                $data['employee_no'] = !empty($row[2]) ? $row[2] : '';
                $data['access_card_id'] = !empty($row[3]) ? $row[3] : '';
                $data['firstname'] = !empty($row[4]) ? $row[4] : '';
                $data['lastname'] = !empty($row[5]) ? $row[5] : '';
                $data['nickname'] = !empty($row[6]) ? $row[6] : '';
                $data['id_card'] = !empty($row[7]) ? $row[7] : '';
                $data['birth_place'] = !empty($row[8]) ? $row[8] : '';
                $data['birth_date'] = !empty($row[9]) ? $row[9] : '';
                $data['gender'] = !empty($row[10]) ? $row[10] : '';
                $data['marital_status'] = !empty($row[11]) ? $row[11] : '';
                $data['religion'] = !empty($row[12]) ? $row[12] : '';
                $data['height'] = !empty($row[13]) ? $row[13] : '';
                $data['weight']      = !empty($row[14]) ? $row[14] : '';
                $data['blood_type']      = !empty($row[15]) ? $row[15] : '';
                $data['id_card_address']      = !empty($row[16]) ? $row[16] : '';
                $data['address']      = !empty($row[17]) ? $row[17] : '';
                $data['tax_number']      = !empty($row[18]) ? $row[18] : '';
                $data['ptkp']      = !empty($row[19]) ? $row[19] : '';
                $data['bpjs_ketenagakerjaan']      = !empty($row[20]) ? $row[20] : '';
                $data['bpjs_kesehatan']      = !empty($row[21]) ? $row[21] : '';
                $data['kta']      = !empty($row[22]) ? $row[22] : '';
                $data['phone_number']      = !empty($row[23]) ? $row[23] : '';
                $data['email']      = !empty($row[24]) ? $row[24] : '';
                $data['clothes_size']      = !empty($row[25]) ? $row[25] : '';
                $data['trouser_size']      = !empty($row[26]) ? $row[26] : '';
                $data['shoes_size']      = !empty($row[27]) ? $row[27] : '';
                $data['language']      = !empty($row[28]) ? $row[28] : '';
                $data['educational_level']      = !empty($row[29]) ? $row[29] : '';
                $data['major']      = !empty($row[30]) ? $row[30] : '';
                $data['skill']      = !empty($row[31]) ? $row[31] : '';
                $data['emergency_contact_name']      = !empty($row[32]) ? $row[32] : '';
                $data['emergency_contact_number']      = !empty($row[33]) ? $row[33] : '';
                $data['division']      = !empty($row[34]) ? $row[34] : '';
                $data['position']      = !empty($row[35]) ? $row[35] : '';
                $data['join_date']      = !empty($row[36]) ? $row[36] : '';
                $data['effective_salary_date']      = !empty($row[37]) ? $row[37] : '';
                $data['basic_salary']      = !empty($row[38]) ? $row[38] : '';
                $data['allowance']      = !empty($row[39]) ? $row[39] : '';

                $user['name'] = $data['nickname'];
                $user['email'] = $data['email'];
                $user['password'] = Hash::make('Def@uLt123');
                $registredUser = User::create($user);
                $data['user_id'] = $registredUser->id;
                $employee = Employee::create($data);

                $totalAllowance = 0;
                if (!empty($data['allowance']) && $this->isJson($data['allowance'])) {
                    $allowances = json_decode($data['allowance'], true);
                    if (is_array($allowances)) {
                        foreach ($allowances as $allowance) {
                            $totalAllowance += $allowance['amount'];
                        }
                    } else {
                        $data['allowance'] = null;
                    }
                } else {
                    $data['allowance'] = null;
                }

                $payrollData = [
                    'employee_id' => $employee->id,
                    'effective_salary_date' => $data['effective_salary_date'],
                    'title' => 'monthly salary',
                    'tax_flag' => 1,
                    'salary_received' => 'Gross',
                    'basic_salary' => $data['basic_salary'],
                    'allowance' => $data['allowance'],
                    'bpjs_ketenagakerjaan' => $data['bpjs_ketenagakerjaan'],
                    'bpjs_kesehatan' => $data['bpjs_kesehatan'],
                    'tax_number' => $data['tax_number'],
                    'tax_type' => $data['ptkp'],
                    'pay_frequency' => 'Monthly'

                ];
                EmployeePayroll::create($payrollData);
            }

            $indexKe++;
        }
    }

    /**
     * Helper function to check if a string is a valid JSON.
     */
    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
