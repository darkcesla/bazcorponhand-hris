<?php

namespace App\Imports;

use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Divisi;

class DivisiImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // dd($collection);
        $indexKe = 1;

        foreach($collection as $row){
            if($indexKe > 1){

                $data['divisi_id']      = !empty($row[1]) ? $row[1] : '';
                $data['name_divisi']       = !empty($row[2]) ? $row[2] : '';
                $data['jumlah']   = !empty($row[3]) ? ($row[3]) : '';

                Divisi::create($data);
            }

            $indexKe++;
        }
    }
}
