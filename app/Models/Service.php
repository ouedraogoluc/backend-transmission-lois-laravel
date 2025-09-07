<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'structure_id',
        'nom',
        'code',
    ];
    /**
     * Get the structure that owns the service.
     */
    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }
    /**
     * Get the users associated with the service.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    /**
     * Get the roles associated with the service.
     */
}
