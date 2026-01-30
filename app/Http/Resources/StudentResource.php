<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Student
 */
final class StudentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_number' => $this->student_number,
            'admission_date' => $this->admission_date?->toDateString(),
            'student_type' => $this->student_type,
            'student_status' => $this->student_status,
            'current_year_level' => $this->current_year_level,
            'scholarship_type' => $this->scholarship_type,
            'current_program' => new StudentProgramResource($this->whenLoaded('currentProgram')),
            'guardians' => StudentGuardianResource::collection($this->whenLoaded('guardians')),
        ];
    }
}
