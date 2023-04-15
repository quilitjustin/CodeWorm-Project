<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    // This will automatically encrypt every id that is retrieved from the database
    public function getIdAttribute($value)
    {
        return encrypt($value);
    }
}