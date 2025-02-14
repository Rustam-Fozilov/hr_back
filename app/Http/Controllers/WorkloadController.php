<?php

namespace App\Http\Controllers;

use App\Enums\WorkLoadEnum;
use App\Http\Requests\Application\WorkloadListRequest;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkloadController extends Controller
{
    public function list(WorkloadListRequest $request): JsonResponse
    {
        if (!$request['type']) throwError('Type required');

        $office = [3, 6, 18, 12, 4, 8, 22, 21];
        $store = [3, 6, 18, 17, 22, 21];

        $query = Department::with(['director'])
            ->when((int) $request['type'] === WorkLoadEnum::OFFICE->value, function ($query) use ($office) {
                return $query->whereIn('departments.id', $office);
            })
            ->when((int) $request['type'] === WorkLoadEnum::STORE->value, function ($query) use ($store) {
                return $query->whereIn('departments.id', $store);
            });

        if (!empty($request['app_id'])) {
            $query->leftJoin('application_workloads', 'departments.id', '=', 'application_workloads.department_id')
                ->where('application_workloads.application_id', (int) $request['app_id'])
                ->whereNotNull('application_workloads.status_id')
                ->select(['departments.*', 'application_workloads.status_id as workload_status_id', 'application_workloads.signed_at']);
        }

        $data = $query->get();
        return success($data);
    }
}
