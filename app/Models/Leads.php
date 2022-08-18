<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leads extends Model
{
    use HasFactory;

    use SoftDeletes;

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
