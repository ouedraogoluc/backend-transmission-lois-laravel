<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];

    // Relation avec les utilisateurs
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    // Relation avec les utilisateurs
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}
