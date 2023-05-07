<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stages extends Model
{
    use HasFactory;

    protected $appends = ['encrypted_id'];

    // This will automatically encrypt every id that is retrieved from the database
    public function getEncryptedIdAttribute()
    {
        return encrypt($this->attributes['id']);
    }

    public function proglang()
    {
        return $this->belongsTo(ProgrammingLanguages::class, 'proglang_id');
    }

    public function badges()
    {
        return $this->belongsTo(Badges::class, 'badge_id');
    }

    public function bgim()
    {
        return $this->belongsTo(BGImg::class, 'bgim_id');
    }

    public function bgm()
    {
        return $this->belongsTo(BGM::class, 'bgm_id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function game_records_users(){
        return $this->hasMany(GameRecord::class, 'stage_id')->where('user_id', Auth::user()->id);
    }

    public function tasks(){
        return $this->hasMany(Tasks::class, 'stage_id');
    }
}
