<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorshipShowResource extends JsonResource
{
   public function toArray($request)
   {
      return [
         "id" => $this->id,
         "observation" => $this->observation,
         "teacher" => [
            "id" => $this->getTeacher->id,
            "first_name" => $this->getTeacher->first_name,
            "first_last_name" => $this->getTeacher->first_last_name,
            "photo_url" => $this->getTeacher->photo_url,
            "email" => $this->getTeacher->email
         ],
         "student" => [
            "id" => $this->getStudent->id,
            "first_name" => $this->getStudent->first_name,
            "first_last_name" => $this->getStudent->first_last_name,
            "photo_url" => $this->getStudent->photo_url,
            "email" => $this->getStudent->email
         ],
         "subject" => [
            "id" => $this->getSubjects->id,
            "name" => $this->getSubjects->name
         ],
         "schedule" => [
            "id" => $this->getSchedule->id,
            "day" => $this->getSchedule->day,
            "start_hour" => $this->getSchedule->start_hour,
            "final_hour" => $this->getSchedule->final_hour,
            "campus" => $this->getSchedule->campus
         ],
         "state" => $this->state
      ];
   }
}
