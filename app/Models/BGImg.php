<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BGImg extends Model
{
    use HasFactory;

    protected $appends = ['encrypted_id'];

    // This will automatically encrypt every id that is retrieved from the database
    public function getEncryptedIdAttribute()
    {
        return encrypt($this->attributes['id']);
    }
}
