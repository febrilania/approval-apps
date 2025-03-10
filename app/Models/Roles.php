<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_name'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
