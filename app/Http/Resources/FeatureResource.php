<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = false;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, // ← Ez a Feature model példány
            'name' => $this->name, // ← Feature model mezők
            'description' => $this->description,
            'user' => new UserResource($this->user), // ← Feature user kapcsolata
            'created_at' => $this->created_at
        ];
    }
}
