<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveAllocation extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'allocated_days',
        'year',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
