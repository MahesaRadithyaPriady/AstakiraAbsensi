<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    protected $fillable = ['user_id', 'tanggal', 'keterangan', 'foto', 'status', 'validated_by', 'catatan_validasi', 'validated_at'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'foto' => 'array',
            'validated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
