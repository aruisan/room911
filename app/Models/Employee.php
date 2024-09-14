<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'internal_id', 'department_id', 'access_allowed'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}
