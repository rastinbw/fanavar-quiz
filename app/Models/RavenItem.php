<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RavenItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'qo_image'
    ];

    protected $hidden = [
        'correct_option_number'
    ];

}
