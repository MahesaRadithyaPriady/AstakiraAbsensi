<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IzinSakit extends Model
{
    protected $fillable = ['user_id', 'jenis', 'tanggal', 'sampai_tanggal', 'keterangan', 'surat', 'status_approval', 'approved_by', 'approved_at'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'sampai_tanggal' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
