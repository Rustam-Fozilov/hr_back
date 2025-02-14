<?php

namespace App\Imports;

use App\Models\Branch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $branch_tokens = array();
        foreach ($collection as $index => $item) {
            if ($index == 0) continue;

            $branch_tokens[] = $item[2];

            Branch::query()->updateOrCreate(
                ['token' => $item[2]],
                ['name' => $item[1]]
            );
        }

        Branch::query()->whereNotIn('token', $branch_tokens)->delete();
    }
}
