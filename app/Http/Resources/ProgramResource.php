<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Program
 */
final class ProgramResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'degree_type' => $this->degree_type,
            'years_to_complete' => $this->years_to_complete,
            'department' => new DepartmentResource($this->whenLoaded('department')),
        ];
    }
}
