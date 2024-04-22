<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class restoration extends Model
{
    use softDeletes;
    protected $fillable = ["user_id", "lending_id", "date_time", "total_good_stuff", "total_defec_stuff"];

    public function user()
    {
        return $this->belongTo(user::class);
    }

    public function lending()
    {
        return $this->belongTo(Lending::class);
    }
}
