<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    function referrer()
    {
        return $this->hasOne(Account::class, 'id', 'ref_by');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function track()
    {
        return $this->hasOne(Track::class);
    }

    public function referrals()
    {
        return $this->hasMany(ReferralLog::class);
    }
}
