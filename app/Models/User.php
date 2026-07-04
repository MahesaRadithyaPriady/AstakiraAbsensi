<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'email', 'password', 'alamat', 'tanggal_lahir', 'nisp', 'foto_profile', 'role', 'tanggal_mulai_pkl', 'tanggal_selesai_pkl'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    public function isPkl(): bool
    {
        return $this->role === 'pkl';
    }

    public function isPembimbing(): bool
    {
        return $this->role === 'pembimbing';
    }

    public function anakPkl(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pembimbing_pkl', 'pembimbing_id', 'pkl_id');
    }

    public function pembimbing(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pembimbing_pkl', 'pkl_id', 'pembimbing_id');
    }

    public function isPklActive(): bool
    {
        if (!$this->tanggal_mulai_pkl || !$this->tanggal_selesai_pkl) {
            return false;
        }

        $today = now()->toDateString();

        return $today >= $this->tanggal_mulai_pkl->toDateString()
            && $today <= $this->tanggal_selesai_pkl->toDateString();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'tanggal_mulai_pkl' => 'date',
            'tanggal_selesai_pkl' => 'date',
        ];
    }
}
