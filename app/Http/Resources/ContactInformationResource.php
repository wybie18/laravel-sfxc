<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ContactInformation
 */
final class ContactInformationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contact_type' => $this->contact_type,
            'contact_value' => $this->contact_value,
            'is_primary' => $this->is_primary,
            'is_verified' => $this->is_verified,
        ];
    }
}
