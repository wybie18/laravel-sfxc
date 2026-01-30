<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Staff
 */
final class StaffResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_number' => $this->employee_number,
            'staff_level' => $this->staff_level,
            'employment_type' => $this->employment_type,
            'hire_date' => $this->hire_date?->toDateString(),
            'employment_status' => $this->employment_status,
            'office' => new OfficeResource($this->whenLoaded('office')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'position' => new StaffPositionResource($this->whenLoaded('position')),
        ];
    }
}
