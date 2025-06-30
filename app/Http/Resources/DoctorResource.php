<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'department_id' => $this->department_id,
            'designation_id' => $this->designation_id,
            'phone' => $this->phone,
        ];
    }
    public function with(Request $request)
    {
        return [
            'status' => 'success',
            'code' => 200
        ];
    }
}
