<?php

namespace App\Imports;

use App\Jobs\UserImportJob2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $item) {
            if ($index == 0 || $index == 1) continue;

            if (empty($item[2]) || $item[2] == '#NULL!') continue;

            dispatch(new UserImportJob2($item->toArray()));
        }
    }
}
