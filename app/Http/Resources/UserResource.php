<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
final class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rfid_uid' => $this->rfid_uid,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at?->toIso8601String(),
            'is_active' => $this->is_active,
            'last_login_at' => $this->last_login_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),

            // User type indicator
            'user_type' => $this->getUserType(),

            // Related information
            'person' => new PersonResource($this->whenLoaded('person')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),

            // User type specific information (only one will be present)
            'student' => new StudentResource($this->whenLoaded('student')),
            'faculty' => new FacultyResource($this->whenLoaded('faculty')),
            'staff' => new StaffResource($this->whenLoaded('staff')),
        ];
    }

    /**
     * Determine the user type based on related records.
     */
    private function getUserType(): ?string
    {
        if ($this->relationLoaded('student') && $this->student !== null) {
            return 'student';
        }

        if ($this->relationLoaded('faculty') && $this->faculty !== null) {
            return 'faculty';
        }

        if ($this->relationLoaded('staff') && $this->staff !== null) {
            return 'staff';
        }

        return null;
    }
}
