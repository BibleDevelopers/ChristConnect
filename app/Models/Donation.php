<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'goal_amount',
        'collected_amount',
    ];

    public function options()
    {
        return $this->hasMany(DonationOption::class);
    }
}
