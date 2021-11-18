<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'name',
    ];

    public function teach()
    {
        return $this->hasMany(Teach::class, 'subjects_id', 'id');
    }
}
