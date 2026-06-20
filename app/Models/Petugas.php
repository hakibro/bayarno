<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';

    protected $fillable = ['user_id', 'nama', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toggleHistory()
    {
        return $this->hasMany(ToggleHistory::class);
    }
}
