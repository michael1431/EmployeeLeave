<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function Leave(){
        return $this->belongsToMany(Leave::class)->withPivot(['leave_start','leave_end'])
            ->withTimestamps();
    }
}
