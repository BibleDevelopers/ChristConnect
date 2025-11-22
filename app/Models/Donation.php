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

    // ensure numeric attributes have expected types
    protected $casts = [
        'goal_amount' => 'integer',
        'collected_amount' => 'integer',
    ];

    public function options()
    {
        return $this->hasMany(DonationOption::class);
    }
}
