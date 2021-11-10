<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeachGetSubjectsResource extends JsonResource
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
         'teacher_id' => $this->teacher_id,
         'subjects_id' => $this->subjects_id,
         'name' => $this->getSubjects->name
      ];
   }
}
