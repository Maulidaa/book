<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestUpdateRole extends Model
{
    protected $fillable = [
        'user_id',
        'role_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
