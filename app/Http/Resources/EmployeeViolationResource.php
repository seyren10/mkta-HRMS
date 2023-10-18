<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeViolationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =   [
            ...parent::toArray($request),
            'violation' => new ViolationResource($this->violation)
        ];
        if ($request->has('includeEmployee'))
            $data['employee'] = new EmployeeResource($this->employee);

        return $data;
    }
}
