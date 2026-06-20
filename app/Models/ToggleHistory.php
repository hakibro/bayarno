<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToggleHistory extends Model
{
    protected $table = 'toggle_history';

    protected $fillable = [
        'siswa_id',
        'petugas_id',
        'action',
        'no_hp_temporary',
        'scheduled_return_at',
        'returned_at'
    ];

    protected $casts = [
        'scheduled_return_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
