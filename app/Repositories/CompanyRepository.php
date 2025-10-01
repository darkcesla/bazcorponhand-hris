<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository {

    public function getList()
    {
        $query = Company::query();
        $data = $query->get();
        return $data;
    }

    
    public function show(int $id)
    {
        $data = Company::find($id);
        return $data;
    }

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function update(int $id, array $data)
    {
        return Company::where('id', $id)->update($data);
    }
    
    public function delete($id)
    {
        $data = Company::findOrFail($id);
        $data->delete();
        return true;
    }
}