<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin'; // Pastikan tabelnya sesuai

    protected $fillable = [
        'email',
        'password',
        'device_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
