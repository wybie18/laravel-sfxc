<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Person
 */
final class PersonResource extends JsonResource
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
            'suffix' => $this->suffix,
            'full_name' => $this->full_name,
            'formal_name' => $this->formal_name,
            'date_of_birth' => $this->date_of_birth?->toDateString(),
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'civil_status' => $this->civil_status,
            'profile_photo_path' => $this->profile_photo_path,
            'contact_information' => ContactInformationResource::collection($this->whenLoaded('contactInformation')),
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}
