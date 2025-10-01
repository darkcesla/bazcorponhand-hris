<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\LogRepository;

class UserController extends Controller
{

    protected $UserRepository;
    protected $employee_repository;
    protected $log_repository;

    public function __construct(
        UserRepository $UserRepository,
        EmployeeRepository $employee_repository,
        LogRepository $log_repository
    ) {
        $this->UserRepository = $UserRepository;
        $this->employee_repository = $employee_repository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $user = $this->UserRepository->getList();
        return view('user.index', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
        ]);
        $data['password']   = Hash::make($request->input('password'));
        $employee_id = $request->input('employee_id');
        $user = $this->UserRepository->create($data);
        $this->log_repository->logActivity('Created user', $request->ip());
        $this->employee_repository->update($employee_id, ['user_id' => $user->id]);
        return redirect()->route('admin.user');
    }

    public function create()
    {
        $employee = $this->employee_repository->getListParams();
        return view('user.create', ['employees' => $employee]);
    }

    public function edit($id)
    {
        $user = $this->UserRepository->show($id);
        return view('user.edit', ['user' => $user]);
    }

    public function show($id)
    {
        $user = $this->UserRepository->show($id);
        return view('user.show', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $data =  $request->only([
            'name',
            'email',
        ]);
        $data['password']   = Hash::make($request->input('password'));
        $succesStatus = $this->UserRepository->update($id, $data);
        $this->log_repository->logActivity('Updated user with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.user')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->UserRepository->delete($id);
        $this->log_repository->logActivity('Deleted user with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.user')->with('success', 'Data updated successfully!');
    }
}
