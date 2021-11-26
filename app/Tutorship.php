<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorship extends Model
{
   protected $table = 'tutorship';

   protected $fillable = [
      'teacher_id',
      'student_id',
      'subjects_id',
      'schedule_id',
      'observation'
   ];

   public function getTeacher()
   {
      return $this->belongsTo(User::class, 'teacher_id');
   }

   public function getStudent()
   {
      return $this->belongsTo(User::class, 'student_id');
   }

   public function getSubjects()
   {
      return $this->belongsTo(Subjects::class, 'subjects_id');
   }

   public function getSchedule()
   {
      return $this->belongsTo(Schedule::class, 'schedule_id');
   }

   public function scopeState($query, $value)
   {
      if (!empty($value)) {
         $query->whereIn('state', $value);
      }
   }
}
