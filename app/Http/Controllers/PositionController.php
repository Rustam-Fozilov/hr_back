<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Resources\Resource;
use App\Services\Position\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct(
        protected PositionService $service,
    )
    {
    }

    public function index(ListRequest $request): Resource
    {
        $data = $this->service->list($request->all());
        return new Resource($data);
    }
}
