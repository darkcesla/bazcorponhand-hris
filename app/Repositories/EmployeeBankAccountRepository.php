<?php

namespace App\Repositories;

use App\Models\EmployeeBankAccount;

class EmployeeBankAccountRepository {

    public function getList()
    {
        $query = EmployeeBankAccount::query();
        $data = $query->with('employee')->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = EmployeeBankAccount::with('employee')->find($id);
        return $data;
    }

    public function create(array $data)
    {
        return EmployeeBankAccount::create($data);
    }

    public function update(int $id, array $data)
    {
        return EmployeeBankAccount::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = EmployeeBankAccount::findOrFail($id);
        $data->delete();
        return true;
    }
}