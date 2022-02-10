<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'level',
        'number',
        'exercises'
    ];
}
