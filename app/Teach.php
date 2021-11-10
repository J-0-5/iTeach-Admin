<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teach extends Model
{
   protected $table = 'teach';

   protected $fillable = [
      'teacher_id',
      'subjects_id'
   ];

   public function getUsers()
   {
      return $this->belongsTo(User::class, 'teacher_id');
   }

   public function getSubjects()
   {
      return $this->belongsTo(Subject::class, 'subjects_id');
   }

   /** FILTER **/
   public function scopeTeach($query, $teacherId)
   {
      if (!empty($teacherId)) {
         $query->where('teacher_id', $teacherId);
      }
   }

   public function scopeSubject($query, $subjectId)
   {
      if (!empty($subjectId)) {
         $query->where('subjects_id', $subjectId);
      }
   }
}
