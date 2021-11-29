<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';

    protected $fillable = [
        'teacher_id',
        'day',
        'start_hour',
        'final_hour',
        'campus',
    ];

    public function getDay()
    {
        return $this->hasOne(ParameterValue::class, 'id', 'day')->select(['id', 'name']);
    }

    public function getCampus()
    {
        return $this->hasOne(ParameterValue::class, 'id', 'campus')->select(['id', 'name']);
    }

    public function scopeTeacher($query, $id)
    {
        if (trim($id) != null) {
            $query->where('teacher_id', $id);
        }
    }

    public function scopeDay($query, $id)
    {
        if (trim($id) != null) {
            $query->where('day', $id);
        }
    }
}
