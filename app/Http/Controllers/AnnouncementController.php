<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\AnnouncementRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;

class AnnouncementController extends Controller
{
    protected $announcement_repository;
    protected $company_repository;
    protected $user_repository;
    protected $log_repository;
    protected $employee_repository;
    protected $notification_repository;

    public function __construct(
        AnnouncementRepository $announcement_repository,
        CompanyRepository $company_repository,
        EmployeeRepository $employee_repository,
        NotificationRepository $notification_repository,
        LogRepository $log_repository,
        UserRepository $user_repository,
    ) {
        $this->announcement_repository = $announcement_repository;
        $this->company_repository = $company_repository;
        $this->log_repository = $log_repository;
        $this->user_repository = $user_repository;
        $this->employee_repository = $employee_repository;
        $this->notification_repository = $notification_repository;
    }

    public function index()
    {
        $params = [];
        if (session('selected_company') != 0) {
            $params['company_id'] = session('selected_company');
        }
        $announcements = $this->announcement_repository->getList($params);
        return view('announcement.index', ['announcements' => $announcements]);
    }


    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'company_id',
            'content',
        ]);
        if (empty($data['company_id'])) {
            $data['company_id'] = null;
        }
        try {
            $params = [];
            if (!empty($data['company_id'])) {
                $params['company_id'] = $data['company_id'];
            }
            $announcement = $this->announcement_repository->create($data);
            $users = $this->employee_repository->getListUser($params);
            foreach ($users as $user) {
                $notifData = [
                    'user_id' => $user,
                    'title' => $data['title'],
                    'description' => $data['content'],
                    'url' =>  'https://bazcorponhand.com/public/admin/announcement/' .  $announcement->id,
                ];
                $this->notification_repository->create($notifData);
            }

            $this->log_repository->logActivity('Created announcement', $request->ip());
            return redirect()->route('admin.announcement');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        $company = $this->company_repository->getList();
        return view('announcement.create', ['company' => $company])->with('success', 'Data updated successfully!');
    }

    public function edit($id)
    {
        $company = $this->company_repository->getList();
        $announcement = $this->announcement_repository->show($id);
        return view('announcement.edit', ['announcement' => $announcement, 'company' => $company]);
    }

    public function show($id)
    {
        $announcement = $this->announcement_repository->show($id);
        return view('announcement.show', ['announcement' => $announcement]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'title',
            'company_id',
            'content',
        ]);
        $succesStatus = $this->announcement_repository->update($id, $data);
        $this->log_repository->logActivity('Updated announcement with id ' . $id . '', $request->ip());
        return redirect()->route('admin.announcement')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $succesStatus = $this->announcement_repository->delete($id);
            $this->log_repository->logActivity('Deleted announcement with id ' . $id . '', $request->ip());
            return redirect()->route('admin.announcement')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.announcement')
                ->with('error', 'An error occurred, please try again later.')
                ->with('error_message', $e->getMessage());
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
            if (!$employee) {
                return response()
                    ->json(['message' => 'Invalid token', 'data' => null], 401);
            }
            $data = $request->only(['page', 'per_page']);
            if (!$employee->user->role === 'admin'|| $employee->user->role === null) {
                $data['company_id'] = $employee->company_id;
            }
            $result = $this->announcement_repository->getList($data);

            if (empty($result)) {
                return response()
                    ->json(['message' => 'No data found', 'data' => null], 404);
            }
            $nextPageUrl = $result->nextPageUrl();
            $previousPageUrl = $result->previousPageUrl();
            $total = $result->total();
            $perPage = $result->perPage();
            $currentPage = $result->currentPage();
            $lastPage = $result->lastPage();
            $response = [
                'message' => 'success',
                'data' => $result->items(),
                'next_page_url' => $nextPageUrl,
                'previous_page_url' => $previousPageUrl,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => $lastPage,
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
}
