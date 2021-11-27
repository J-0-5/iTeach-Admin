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
      'date',
      'observation'
   ];
}
