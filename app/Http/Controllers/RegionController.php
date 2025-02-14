<?php

namespace App\Http\Controllers;

use App\Http\Resources\Resource;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function list(Request $request)
    {
        $regions = Region::query()
            ->when(!empty($request['search']), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name_uz', 'like', '%' . $request['search'] . '%')
                        ->orWhere('name_uzc', 'like', '%' . $request['search'] . '%')
                        ->orWhere('name_ru', 'like', '%' . $request['search'] . '%');
                });
            })
            ->paginate($request->get('per_page') ?? 15);

        return new Resource($regions);
    }
}
