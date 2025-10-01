<?php

namespace App\Http\Controllers;

use App\Models\EmployeeShift as ModelsEmployeeShift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Repositories\EmployeeRepository;
use App\Repositories\AnnouncementRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeShiftRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\EmployeeCareerRepository;

class HomeController extends Controller
{
    protected $employee_repository;
    protected $attendanceRepository;
    protected $announcement_repository;
    protected $employeeShiftRepository;
    protected $notification_repository;
    protected $employee_career_repository;

    public function __construct(
        AttendanceRepository $attendanceRepository,
        EmployeeRepository $employee_repository,
        AnnouncementRepository $announcement_repository,
        EmployeeShiftRepository $employeeShiftRepository,
        NotificationRepository $notification_repository,
        EmployeeCareerRepository $employee_career_repository,
    ) {
        $this->employee_repository = $employee_repository;
        $this->announcement_repository = $announcement_repository;
        $this->attendanceRepository = $attendanceRepository;
        $this->employeeShiftRepository = $employeeShiftRepository;
        $this->notification_repository = $notification_repository;
        $this->employee_career_repository = $employee_career_repository;
    }

    public function dashboard()
    {
        return view('dashboard.dashboard');

        return abort(403);
    }

    public function index()
    {
        $params = [];
        if (session('selected_company') != 0) {
            $params['company_id'] = session('selected_company');
        }
        $params['last_contract'] = true;
        $ratio = $this->employee_repository->getGenderRatio($params);
        $attendanceIssues = $this->attendanceRepository->getAttendanceIssue($params);
        $announcementData = $this->announcement_repository->getList($params);
        $expiredContract = $this->employee_career_repository->getList($params['last_contract']);
        $params['user_id'] = auth()->user()->id;
        $notifications = $this->notification_repository->getList($params);
        $total = 0;
        foreach ($ratio as $r) {
            $total += $r->count;
        }
        $notifCount = 0;
        foreach ($notifications as $notification) {
            if ($notification->read_at == null) {
                $notifCount++;
            }
        }
        return view('dashboard.dashboard', [
            'ratio' => $ratio,
            'attendanceIssues' => $attendanceIssues,
            'notifCount' => $notifCount,
            'notifications' => $notifications,
            'announcementData' => $announcementData,
            'total' => $total,
            'expiredContract' => $expiredContract
        ]);
    }

    public function userIndex()
    {
        $currentDate = (new \DateTime())->format('Y-m-d');
        $params = [];
        $params['company_id'] = session('selected_company');
        $employee_id = $this->employee_repository->getByUserId(auth()->user()->id)->id;
        $params['employee_id'] = $employee_id;
        $params['user_id'] = auth()->user()->id;
        $notifications = $this->notification_repository->getList($params);
        $weeklyShift = $this->employeeShiftRepository->getList($params);
        $notifCount = 0;
        foreach ($notifications as $notification) {
            if ($notification->read_at == null) {
                $notifCount++;
            }
        }
        return view('dashboard.user_dashboard', ['notifications' => $notifications, 'weeklyShift' => $weeklyShift, 'currentDate' => $currentDate, 'notifCount' => $notifCount]);
    }

    public function assets(Request $request)
    {

        $data = new User;

        if ($request->get('search')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }

        if ($request->get('tanggal')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('assets', compact('data', 'request'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:png,jpg,jpeg|max:2048',
            'email' => 'required|email',
            'nama'  => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $photo      = $request->file('photo');
        $filename   = date('Y-m-d') . $photo->getClientOriginalName();
        $path       = 'photo-user/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($photo));


        $data['email']      = $request->email;
        $data['name']       = $request->nama;
        $data['password']   = Hash::make($request->password);
        $data['image']      = $filename;

        User::create($data);

        return redirect()->route('admin.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'nama'      => 'required',
            'password'  => 'nullable',
            'photo'     => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $find = User::find($id);

        $data['email']      = $request->email;
        $data['name']       = $request->nama;

        if ($request->password) {
            $data['password']   = Hash::make($request->password);
        }

        $photo      = $request->file('photo');

        if ($photo) {

            $filename   = date('Y-m-d') . $photo->getClientOriginalName();
            $path       = 'photo-user/' . $filename;

            if ($find->image) {
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }

            Storage::disk('public')->put($path, file_get_contents($photo));

            $data['image']      = $filename;
        }

        $find->update($data);

        return redirect()->route('admin.index');
    }
}
