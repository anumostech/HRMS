<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'org_name',
        'phone',
        'email',
        'logo',
        'has_multiple_companies',
        'address'
    ];

    protected $casts = [
        'has_multiple_companies' => 'boolean'
    ];

    public function companies()
    {
        return $this->hasMany(Company::class, 'organisation_id');
    }
}
