<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'organization_name',
        'username',
        'password',
        'pin'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
