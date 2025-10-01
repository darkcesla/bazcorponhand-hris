<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;

class UserRepository
{

    public function getList()
    {
        try {
            $query = User::query();
            $data = $query->get();
            return $data;
        } catch (\Exception $e) {
            // Handle exception here
            return $e->getMessage();
        }
    }


    public function show(int $id)
    {
        try {
            $data = User::find($id);
            return $data;
        } catch (\Exception $e) {
            // Handle exception here
            return $e->getMessage();
        }
    }

    public function create(array $data)
    {
        try {
            return User::create($data);
        } catch (\Exception $e) {
            // Handle exception here
            return $e->getMessage();
        }
    }

    public function update(int $id, array $data)
    {
        try {
            return User::where('id', $id)->update($data);
        } catch (\Exception $e) {
            // Handle exception here
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $data = User::findOrFail($id);
            $data->delete();
            return true;
        } catch (\Exception $e) {
            // Handle exception here
            return $e->getMessage();
        }
    }

    public function login_proses($data)
    {
        try {
            if (Auth::attempt($data)) {
                $loginUser = Auth::user();
                if ($loginUser) {
                    $user = User::find($loginUser->id);
                    $user->setRememberToken(Str::random(60));
                    $user->last_login = Carbon::now();
                    $user->save();
                    return $user;
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function checkToken(string $token)
    {
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            $employee = Employee::where('user_id', $user->id)->with('user')->first();
            return $employee;
        }
        return $user;
    }

    public function checkEmail(string $email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }
}
