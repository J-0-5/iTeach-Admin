<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

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
            $now = new Date();
            if (in_array(13, $value)) {
                $query->whereDate('date', '>=', date('Y-m-d'));
            }
            if (in_array(14, $value)) {
                $query->whereDate('date', '<', date('Y-m-d'));
            }
        }
    }
}
