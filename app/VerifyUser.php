<?php

namespace WT2projekt;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('WT2projekt\User', 'user_id');
    }
}
