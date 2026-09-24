<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}