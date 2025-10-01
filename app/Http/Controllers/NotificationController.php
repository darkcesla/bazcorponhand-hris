<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\AnnouncementRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notification_repository;
    protected $employee_repository;
    protected $announcement_repository;

    public function __construct(
        NotificationRepository $notification_repository,
        EmployeeRepository $employee_repository,
        AnnouncementRepository $announcement_repository,
    ) {
        $this->notification_repository = $notification_repository;
        $this->employee_repository = $employee_repository;
        $this->announcement_repository = $announcement_repository;
    }

    public function index()
    {
        $params = [];
        $userId = auth()->user()->id;
        $params['employee_id'] = $userId;
        $notification = $this->notification_repository->getList($params);
        return view('notification.index', ['notification' => $notification]);
    }
    public function store($data)
    {
        $this->notification_repository->create($data);
        return redirect()->route('admin.notification');
    }

    public function show($id)
    {
        $this->notification_repository->read($id);
        $notification = $this->notification_repository->show($id);
        return redirect($notification->url);
    }

    public function destroy($id)
    {
        $succesStatus = $this->notification_repository->delete($id);
        return redirect()->route('admin.notification')->with('success', 'Data updated successfully!');
    }
}
