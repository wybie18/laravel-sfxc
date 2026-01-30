<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\StudentProgram;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin StudentProgram
 */
final class StudentProgramResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_current' => $this->is_current,
            'enrollment_date' => $this->enrollment_date?->toDateString(),
            'expected_graduation' => $this->expected_graduation?->toDateString(),
            'status' => $this->status,
            'program' => new ProgramResource($this->whenLoaded('program')),
            'curriculum' => new CurriculumResource($this->whenLoaded('curriculum')),
        ];
    }
}
