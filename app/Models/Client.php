<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_type',
        'poc_name',
        'phone',
        'email',
        'city',
        'address',
        'is_active',
        'location_url'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
