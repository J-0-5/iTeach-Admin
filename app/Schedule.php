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
}
