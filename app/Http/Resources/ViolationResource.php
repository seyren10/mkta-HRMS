<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\ViolationTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ViolationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);

        $data['disciplinaryActions']  =  DisciplinaryActionResource::collection($this->disciplinaryActions);

        if ($request->has('includeViolationType'))
            $data['violationType']  = new ViolationTypeResource($this->violationType);

        return $data;
    }
}
