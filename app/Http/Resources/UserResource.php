<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $isCollection = $this->resource instanceof Collection;

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position->name,
            'position_id' => $this->position_id,
            'photo' => $this->photo,
        ];

        if ($isCollection) {
            $data['registration_timestamp'] = $this->created_at->timestamp;
        }

        return $data;
    }
}
