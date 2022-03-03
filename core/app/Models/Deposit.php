<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $guarded = ['id'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
