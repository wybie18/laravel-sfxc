<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Faculty
 */
final class FacultyResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_number' => $this->employee_number,
            'employment_type' => $this->employment_type,
            'faculty_rank' => $this->faculty_rank,
            'specialization' => $this->specialization,
            'hire_date' => $this->hire_date?->toDateString(),
            'employment_status' => $this->employment_status,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'specializations' => SpecializationResource::collection($this->whenLoaded('specializations')),
        ];
    }
}
