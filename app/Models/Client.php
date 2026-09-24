<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'location',
        'description',
        'contact_name',
        'contact_email',
        'accent_color',
    ];
}   