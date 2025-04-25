<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'client_id',
        'organization_name',
        'form_name',
        'description',
        'renewal_date',
        'status',
        'send_reminder',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }


}
