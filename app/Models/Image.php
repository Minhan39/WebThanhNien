<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
      'path',
      'audio_path',
      'name',
      'alt',
      'description',
      'is_show',
      'order',
  ];

  protected $attributes = [
    'is_show' => true,
    'order' => 0,
  ];
}
