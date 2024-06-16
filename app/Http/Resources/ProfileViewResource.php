<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $permissions = $this->getAllPermissions();
        $roles = $this->getRoleNames();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'profil_image'=>$this->profil_image ? Storage::url($this->profil_image) :"There is no image uploaded!",
            'permissions' => $permissions,
            'roles' => $roles,
            'created_at'=>$this->created_at->format('Y-m-d'),
            'updated_at'=>$this->updated_at->format('Y-m-d'),
        ];
    }
}
