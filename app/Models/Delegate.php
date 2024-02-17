<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'delegate_id',
        'unit',
        'image',
        'card',
        'phone',
        'is_guest'
    ];
}
