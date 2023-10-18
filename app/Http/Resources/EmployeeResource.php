<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = 'employee';
    public function toArray(Request $request): array
    {
        $data =  [
            ...parent::toArray($request),
            'full_name' => Str::of($this->first_name . " " . $this->last_name)->headline(),
            'department' => new DepartmentResource($this->ownedByDepartment),
        ];

        if ($request->has('includeEmployeeViolations'))
            $data['employeeViolations'] = EmployeeViolationResource::collection($this->employeeViolations);

        return $data;
    }
}
