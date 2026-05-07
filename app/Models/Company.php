<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'company_name',
        'phone',
        'email',
        'logo',
        'address',
        'trade_license_name',
        'trade_license_number',
        'trade_license_expiry',
        'trade_license_attachment',
        'establishment_card_number',
        'establishment_card_expiry',
        'establishment_card_attachment',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
