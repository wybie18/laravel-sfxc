<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\StudentGuardian;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin StudentGuardian
 */
final class StudentGuardianResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'relationship' => $this->relationship,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'occupation' => $this->occupation,
            'address' => $this->address,
            'is_primary' => $this->is_primary,
            'is_emergency_contact' => $this->is_emergency_contact,
        ];
    }
}
