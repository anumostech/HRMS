<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'type',
        'description',
        'file_path',
        'folder',
        'party_id',
        'share_with',
        'expiry_date'
    ];


    public function setExpiryDateAttribute($value)
    {
        if ($value) {
            try {
                // If it's already in Y-m-d, just store it
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                    $this->attributes['expiry_date'] = $value;
                } else {
                    $this->attributes['expiry_date'] = Carbon::createFromFormat('d-m-Y', $value)
                        ->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // Fallback attempt or just store as is if it's already a valid date string
                $this->attributes['expiry_date'] = Carbon::parse($value)->format('Y-m-d');
            }
        } else {
            $this->attributes['expiry_date'] = null;
        }
    }

    public function shareWith()
    {
        return $this->belongsTo(User::class, 'share_with', 'id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }
}
