<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
                "role" => $this->getTeacher->role->id,
                "full_name" => $this->getTeacher->first_name . ' ' . $this->getTeacher->second_name . ' ' . $this->getTeacher->first_last_name . ' ' . $this->getTeacher->second_last_name,
                "first_name" => $this->getTeacher->first_name,
                "second_name" => $this->getTeacher->second_name,
                "first_last_name" => $this->getTeacher->first_last_name,
                "second_last_name" => $this->getTeacher->second_last_name,
                "photo_url" => $this->getTeacher->photo_url,
                "email" => $this->getTeacher->email
            ],
            "student" => [
                "id" => $this->getStudent->id,
                "full_name" => $this->getStudent->first_name . ' ' . $this->getStudent->second_name . ' ' . $this->getStudent->first_last_name . ' ' . $this->getStudent->second_last_name,
                "first_name" => $this->getStudent->first_name,
                "second_name" => $this->getStudent->second_name,
                "first_last_name" => $this->getStudent->first_last_name,
                "second_last_name" => $this->getStudent->second_last_name,
                "photo_url" => $this->getStudent->photo_url,
                "email" => $this->getStudent->email
            ],
            "subject" => [
                "id" => $this->getSubjects->id,
                "name" => $this->getSubjects->name
            ],
            "schedule" => [
                "id" => $this->getSchedule->id,
                "day" => $this->getSchedule->getDay->name,
                "start_hour" => $this->getSchedule->start_hour,
                "final_hour" => $this->getSchedule->final_hour,
                "campus" => $this->getSchedule->getCampus->name
            ],
            "date" => Carbon::parse($this->date)->format('d/m/Y'),
            "diffForHumans" => Carbon::parse($this->date)->diffForHumans(),
            "state" => $this->state
        ];
    }
}
