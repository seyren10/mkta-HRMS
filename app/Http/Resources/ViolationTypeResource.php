<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViolationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            ...parent::toArray($request),
            'violation_type' => Str::of($this->violation_type)->headline(),

        ];
        if ($request->has('includeViolations')) {
            $data['violations'] = ViolationResource::collection($this->violations);
        }
        if ($request->has('includeDisciplinaryActions')) {
            $data['disciplinaryActions'] = ViolationResource::collection($this->disciplinaryActions);
        }

        return $data;
    }
}
