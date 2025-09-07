<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'nom',
    ];

    /**
     * Get the services associated with the structure.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    /**
     * Get the users associated with the structure.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    /**
     * Get the roles associated with the structure.
     */
}
