<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenunganComment extends Model
{
    use HasFactory;

    protected $fillable = ['renungan_id', 'user_id', 'content'];

    public function renungan()
    {
        return $this->belongsTo(Renungan::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
