<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'successful'];



    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
