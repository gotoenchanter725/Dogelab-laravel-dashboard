<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralLog extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function referee()
    {
        return $this->belongsTo(Account::class, 'ref_user_id');
    }
}
