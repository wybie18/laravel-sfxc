<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Curriculum
 */
final class CurriculumResource extends JsonResource
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
            'effective_year' => $this->effective_year,
            'is_active' => $this->is_active,
        ];
    }
}
