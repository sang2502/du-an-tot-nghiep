<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'gender', 'birth_date', 'address',
        'points', 'tier', 'role_id'
    ];

    public function role() {
        return $this->belongsTo(Role::class,'role_id');
    }

}
