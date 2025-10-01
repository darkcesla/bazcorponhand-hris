<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\AttendanceLocationRepository;
use Illuminate\Http\Request;
use App\Repositories\LogRepository;


class AttendanceLocationController extends Controller
{
    protected $attendanceLocationRepository;
    protected $log_repository;


    public function __construct(
        AttendanceLocationRepository $attendanceLocationRepository,
        LogRepository $log_repository
    ) {
        $this->attendanceLocationRepository = $attendanceLocationRepository;
        $this->log_repository = $log_repository;
    }

    public function index()
    {
        $attendanceLocation = $this->attendanceLocationRepository->getList();
        return view('attendance_location.index', ['attendanceLocation' => $attendanceLocation]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'location_code',
            'location_name',
            'location_address',
            'city',
            'province',
            'country',
            'max_radius',
            'longitude',
            'latitude',
        ]);

        $succesStatus = $this->attendanceLocationRepository->create($data);
        $this->log_repository->logActivity('Created attendance location', $request->ip());

        return redirect()->route('admin.attendance_location')->with('success', 'Data updated successfully!');
    }

    public function create()
    {
        return view('attendance_location.create');
    }

    public function edit($id)
    {
        $attendance_location = $this->attendanceLocationRepository->show($id);
        return view('attendance_location.edit', ['attendance_location' => $attendance_location]);
    }

    public function show($id)
    {
        $attendance_location = $this->attendanceLocationRepository->show($id);
        return view('attendance_location.show', ['attendance_location' => $attendance_location]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'location_code',
            'location_name',
            'location_address',
            'city',
            'province',
            'country',
            'max_radius',
            'longitude',
            'latitude',
        ]);
        $succesStatus = $this->attendanceLocationRepository->update($id, $data);
        $this->log_repository->logActivity('Updated attendance location with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.attendance_location')->with('success', 'Data updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $succesStatus = $this->attendanceLocationRepository->delete($id);
        $this->log_repository->logActivity('Deleted attendance location with id: ' . $id, '', $request->ip());
        return redirect()->route('admin.attendance_location')->with('success', 'Data updated successfully!');
    }

    public function getLocation()
    {

        $attendanceLocation = $this->attendanceLocationRepository->getList();
        return response()->json($attendanceLocation);
    }
}
