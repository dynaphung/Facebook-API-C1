<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'like_date' => $this->created_at->format('d/m/Y'),
        ];
    }
}
