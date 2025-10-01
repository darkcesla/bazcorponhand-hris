<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    protected $userRepository;
    protected $employee_repository;

    public function __construct(
        UserRepository $userRepo,
        EmployeeRepository $employee_repository,
    ) {
        $this->userRepository = $userRepo;
        $this->employee_repository = $employee_repository;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);

        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $user->setRememberToken(Str::random(60));
            session([
                'selected_company' => 0
            ]);
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                $employee = $this->employee_repository->getByUserId($user->id);
                session()->put('selected_company', $employee->company_id);
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah');
        }
    }

    public function login_api(Request $request)
    {
        try {
            $request->validate([
                'email'     => 'required',
                'password'  => 'required',
            ]);

            $data = $request->only('email', 'password');

            $user = $this->userRepository->login_proses($data);
            $employee = $this->employee_repository->getByUserId($user->id);
            if ($user) {
                $user_data = [
                    'token' => $user->remember_token,
                    'id' => $user->id,
                    'name' => $user->name,
                    'image' => $employee->image
                ];
                $response = [
                    'message' => 'success',
                    'data' => $user_data
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'message' => 'Invalid email or password',
                    'data' => null
                ];
                return response()->json($response, 404);
            }
        } catch (\Exception $e) {
            $response = [
                'message' => $e->getMessage(),
                'data' => null
            ];
            return response()->json($response, 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $token = $this->userRepository->checkEmail($request->email)->remember_token;

        Mail::send('auth.password-reset', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Request');
        });

        return back()->with('success', 'Reset link sent to your email.');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-form', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $employee = $this->userRepository->checkToken($request->token);
        if (!$employee || $employee->user->remember_token !== $request->token) {
            return back()->with('error', 'Invalid token.');;
        }

        try {
            $data['password']   = Hash::make($request->input('password'));
            $this->userRepository->update($employee->user->id, $data);
            return redirect()->route('login')->with('success', 'Password has been reset!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reset password. Please try again.');;
        }
    }
}
