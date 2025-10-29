<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'label',
        'amount',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}

