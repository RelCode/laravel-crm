<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'names',
        'profession',
        'email',
        'phone',
        'owner',
        'stage'
    ];
}
