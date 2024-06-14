<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class lending extends Model
{
    use softDeletes;
    protected $fillable = ["stuff_id", "date_time", "name", "user_id", "notes", "total_stuff"];

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function stuff()
    {
        return $this->belongTo(stuff::class);
    }

    public function restorations()
    {
        return $this->hasOne(Restoration::class);
    }
}

