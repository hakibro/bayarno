<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'idperson',
        'nama',
        'no_hp_asli',
        'no_hp_aktif',
        'no_hp_pemilik',
        'unit_formal',
        'kelas_formal',
        'asrama_pondok',
        'kamar_pondok',
        'tingkat_diniyah',
        'kelas_diniyah'
    ];

    public function toggleHistory()
    {
        return $this->hasMany(ToggleHistory::class);
    }

    /**
     * Check if student currently has an active toggle
     */
    public function getIsToggledAttribute()
    {
        return $this->toggleHistory()
            ->whereNull('returned_at')
            ->exists();
    }
}
