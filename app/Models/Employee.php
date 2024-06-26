<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'contact',
            'gender',
            'date_of_birth',
            'address',
            'photo',
    ];
}
