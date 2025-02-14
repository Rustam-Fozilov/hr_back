<?php

namespace App\Services\Position;

use App\Models\Position;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PositionService
{
    public function list(array $data): LengthAwarePaginator
    {
        return Position::query()
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query->where('name', 'like', '%' . translit($data['search'])['lat'] . '%')
                        ->orWhere('name', 'like', '%' . translit($data['search'])['cyr'] . '%');
                });
            })
            ->paginate($data['per_page'] ?? 15);
    }
}
