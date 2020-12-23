<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function Employee(){
        return $this->belongsToMany(Employee::class)->withPivot(['leave_start','leave_end'])
            ->withTimestamps();
    }
}
