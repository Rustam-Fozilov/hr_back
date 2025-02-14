<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Resources\Resource;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function list(ListRequest $request)
    {
        $branch = Branch::query()
            ->when(!empty($request['search']), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . translit($request['search'])['lat'] . '%')
                        ->orWhere('name', 'like', '%' . translit($request['search'])['cyr'] . '%');
                });
            })
            ->when(!empty($request['status']), function ($query) use ($request) {
                $query->where('status', $request['status']);
            })
            ->when(auth()->user()->role_id === 10 || auth()->user()->role_id === 13, function ($query) {
                $query->where(function ($query) {
                    $query->where('id', auth()->user()->branch_id)
                        ->orWhereIn('id', auth()->user()->branches->pluck('id')->toArray());
                });
            })
            ->paginate($request['per_page'] ?? 15);

        return new Resource($branch);
    }
}
