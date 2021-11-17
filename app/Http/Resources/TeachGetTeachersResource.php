<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeachGetTeachersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'subjects_id' => $this->subjects_id,
            'teacher_id' => $this->teacher_id,
            'first_name' => $this->getUsers->first_name,
            'second_name' => $this->getUsers->second_name,
            'first_last_name' => $this->getUsers->first_last_name,
            'second_last_name' => $this->getUsers->second_last_name,
            'photo_url' => $this->getUsers->photo_url,
            'email' => $this->getUsers->email,
            'created_at' => $this->getUsers->created_at,
            'updated_at' => $this->getUsers->updated_at
        ];
    }
}
