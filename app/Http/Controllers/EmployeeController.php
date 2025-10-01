<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\PositionRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use App\Repositories\LogRepository;
use App\Repositories\EmployeeTempChangesRepository;
use App\Repositories\NotificationRepository;

class EmployeeController extends Controller
{
    protected $employee_repository;
    protected $company_repository;
    protected $log_repository;
    protected $position_repository;
    protected $user_repository;
    protected $employee_temp_changes_repository;
    protected $notification_repository;

    public function __construct(
        EmployeeRepository $employee_repository,
        CompanyRepository $company_repository,
        PositionRepository $position_repository,
        LogRepository $log_repository,
        UserRepository $user_repository,
        EmployeeTempChangesRepository $employee_temp_changes_repository,
        NotificationRepository $notification_repository,
    ) {
        $this->employee_repository = $employee_repository;
        $this->company_repository = $company_repository;
        $this->log_repository = $log_repository;
        $this->position_repository = $position_repository;
        $this->user_repository = $user_repository;
        $this->employee_temp_changes_repository = $employee_temp_changes_repository;
        $this->notification_repository = $notification_repository;
    }

    public function index()
    {
        try {
            if (session('selected_company') != 0) {
                $employee = $this->employee_repository->getListCompany(session('selected_company'));
            } else {
                $employee = $this->employee_repository->getList();
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('employee.index', ['employee' => $employee]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = $request->only([
            'user_id',
            'employee_no',
            'access_card_id',
            'firstname',
            'lastname',
            'nickname',
            'id_card',
            'birth_place',
            'birth_date',
            'gender',
            'marital_status',
            'religion',
            'height',
            'weight',
            'blood_type',
            'id_card_address',
            'address',
            'kta',
            'phone_number',
            'email',
            'social_media',
            'clothes_size',
            'trouser_size',
            'shoes_size',
            'language',
            'educational_level',
            'major',
            'skill',
            'emergency_contact_name',
            'emergency_contact_number',
            'position_id',
            'agreement_type',
            'join_date',
            'ceritficate',
        ]);

        if (!$request->has('nickname') || !$request->has('email')) {
            return back()->withErrors('Nickname and email are required fields.');
        }
        if (session('selected_company') == 0) {
            return back()->withErrors('Please select a company first.');
        }

        $user['name'] = $request->nickname;
        $user['email'] = $request->email;
        $user['password'] = Hash::make('Def@uLt123');
        $registeredUser = null;
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/photo-user', $imageName);
                $data['image'] = 'storage/photo-user/' . $imageName;
            }
            if ($request->hasFile('certificate')) {
                $certificate = $request->file('certificate');
                $certificateName = time() . '.' . $certificate->getClientOriginalExtension();
                $certificate->storeAs('public/certificates', $certificateName);
                $data['certificate'] = 'storage/certificates/' . $certificateName;
            }
            $registeredUser = User::create($user);
            $data['user_id'] = $registeredUser->id;
            $data['company_id'] = session('selected_company');
            $this->employee_repository->create($data);
        } catch (\Exception $e) {
            if (isset($registeredUser)) {
                $userToDelete = User::find($registeredUser->id);
                if ($userToDelete) {
                    $userToDelete->update([
                        'email' => now()->timestamp. '_' . $userToDelete->email,
                    ]);
                    $userToDelete->delete();
                }
            }
            return back()->withErrors($e->getMessage());
        }

        $this->log_repository->logActivity('Created employee', $request->ip());
        return redirect()->route('admin.employee');
    }

    public function create()
    {
        $params = [];
        $params['company_id'] = session('selected_company');
        $positions = $this->position_repository->getList($params);
        return view('employee.create', ['positions' => $positions]);
    }

    public function edit($id)
    {
        $params = [];
        $params['company_id'] = session('selected_company');
        $position = $this->position_repository->getList($params);
        $employee = $this->employee_repository->show($id);
        return view('employee.edit', ['employee' => $employee, 'positions' => $position]);
    }

    public function show($id)
    {
        $params = [];
        $params['company_id'] = session('selected_company');
        $position = $this->position_repository->getList($params);
        $employee = $this->employee_repository->show($id);
        return view('employee.show', ['employee' => $employee, 'positions' => $position]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'company_id',
            'user_id',
            'employee_no',
            'access_card_id',
            'firstname',
            'lastname',
            'nickname',
            'id_card',
            'birth_place',
            'birth_date',
            'gender',
            'marital_status',
            'religion',
            'height',
            'weight',
            'blood_type',
            'id_card_address',
            'address',
            'kta',
            'phone_number',
            'email',
            'social_media',
            'clothes_size',
            'trouser_size',
            'shoes_size',
            'language',
            'educational_level',
            'major',
            'skill',
            'emergency_contact_name',
            'emergency_contact_number',
            'position_id',
            'agreement_type',
            'join_date',
            'ceritficate',
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs('public/photo-user', $image, $imageName);
                $data['image'] = 'storage/photo-user/' . $imageName;
            }
            if ($request->hasFile('certificate')) {
                $certificate = $request->file('certificate');
                $certificateName = time() . '.' . $certificate->getClientOriginalExtension();
                $certificate->storeAs('public/certificates', $certificateName);
                $data['certificate'] = 'storage/certificates/' . $certificateName;
            }

            $this->employee_repository->update($id, $data);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        $this->log_repository->logActivity('Updated employee with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee')->with('success', 'Data inserted successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->employee_repository->delete($id);
        $this->log_repository->logActivity('Deleted employee with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.employee')->with('success', 'Data updated successfully!');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new EmployeeImport(), $request->file('file'));
            return redirect()->back()->with('success', 'Data inserted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function profile()
    {
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        if ($employee_id) {
            $params = [];
            $employee = $this->employee_repository->show($employee_id);
            $positions = $this->position_repository->getList($params);
            return view('employee.show', ['employee' => $employee, 'positions' => $positions]);
        } else {
            return view('error.500');
        }
    }

    public function get(Request $request)
    {
        $token = $request->header('token');
        if (empty($token)) {
            return response()
                ->json(['message' => 'Token not provided', 'data' => null], 401);
        }
        try {
            $employee = $this->user_repository->checkToken($token);
            $data = [
                'id' => $employee->id,
                'firstname' => $employee->firstname,
                'lastname' => $employee->lastname,
                'nickname' => $employee->nickname,
                'birth_place' => $employee->birth_place,
                'birth_date' => $employee->birth_date,
                'gender' => $employee->gender,
                'marital_status' => $employee->marital_status,
                'religion' => $employee->religion,
                'height' => $employee->height,
                'weight' => $employee->weight,
                'blood_type' => $employee->blood_type,
                'id_card_address' => $employee->id_card_address,
                'address' => $employee->address,
                'phone_number' => $employee->phone_number,
                'clothes_size' => $employee->clothes_size,
                'trouser_size' => $employee->trouser_size,
                'shoes_size' => $employee->shoes_size,
                'image' => $employee->image,
                'position' => $employee->position,
            ];
            $response = [
                'message' => 'success',
                'data' => $data
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'message' => 'An error occurred, please try again later',
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ];
            return response()->json($response, 500);
        }
    }

    public function put(Request $request)
    {
        $token = $request->header('token');
        if (empty($token)) {
            return response()
                ->json(['message' => 'Token not provided', 'data' => null], 401);
        }
        try {
            $employee = $this->user_repository->checkToken($token);
            $data = $request->only([
                'employee_no',
                'access_card_id',
                'firstname',
                'lastname',
                'nickname',
                'id_card',
                'birth_place',
                'birth_date',
                'gender',
                'marital_status',
                'religion',
                'height',
                'weight',
                'blood_type',
                'id_card_address',
                'address',
                'kta',
                'phone_number',
                'email',
                'social_media',
                'clothes_size',
                'trouser_size',
                'shoes_size',
                'language',
                'educational_level',
                'major',
                'skill',
                'emergency_contact_name',
                'emergency_contact_number',
                'position_id',
                'agreement_type',
                'join_date',
                'ceritficate',
            ]);


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs('public/photo-user', $image, $imageName);
                $data['image'] = 'storage/photo-user/' . $imageName;
            }
            if ($request->hasFile('certificate')) {
                $certificate = $request->file('certificate');
                $certificateName = time() . '.' . $certificate->getClientOriginalExtension();
                $certificate->storeAs('public/certificates', $certificateName);
                $data['certificate'] = 'storage/certificates/' . $certificateName;
            }

            $originalData = json_encode([
                'employee_no' => $employee->employee_no,
                'firstname' => $employee->firstname,
                'lastname' => $employee->lastname,
            ]);
            $changedData = json_encode($data);
            $tempData = [
                'record_id' => $employee->id,
                'original_data' => $originalData,
                'changed_data' => $changedData,
                'user_id' => $employee->user_id,
            ];

            $empTempData = $this->employee_temp_changes_repository->create($tempData);
            $notifData = [
                'user_id' => 29,
                'title' => 'Profile Edit Request',
                'description' => 'New profile request',
                'url' =>  'https://bazcorponhand.com/public/admin/employee/change/' . $empTempData->id,
            ];
            $this->notification_repository->create($notifData);

            $response = [
                'message' => 'success',
                'data' => []
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'message' => 'An error occurred, please try again later',
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ];
            return response()->json($response, 500);
        }
    }

    public function changeList()
    {
        $params = [];
        $changeList = $this->employee_temp_changes_repository->getList($params);
        return view('employee.change_list', ['changeList' => $changeList]);
    }

    public function change($id)
    {
        $change = $this->employee_temp_changes_repository->show($id);
        $employee = $this->employee_repository->show($change->record_id);
        return view('employee.change', ['change' => $change, 'employee' => $employee]);
    }

    public function changeApproval(Request $request, $id)
    {
        $approvalData = $request->only([
            'approval_status',
        ]);
        $approvalStatus = $approvalData['approval_status'];
        if ($approvalStatus == 'approved') {
            $approvalData['approved_by'] = auth()->user()->id;
            $this->employee_temp_changes_repository->update($id, $approvalData);
            $changeData = $this->employee_temp_changes_repository->show($id);
            $this->employee_repository->update($changeData->record_id, json_decode($changeData->changed_data, true));
            $this->log_repository->logActivity('Updated employee with id: ' . $changeData->record_id, '', $request->ip());
        } elseif ($approvalStatus == 'rejected') {
            $approvalData['approved_by'] = auth()->user()->id;
            $this->employee_temp_changes_repository->update($id, $approvalData);
        }
        return redirect()->route('admin.employee.change_list')->with('success', 'Data updated successfully!');
    }
}
