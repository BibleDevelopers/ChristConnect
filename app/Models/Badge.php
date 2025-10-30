<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = ['name', 'min_donation', 'icon_url'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
