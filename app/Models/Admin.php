<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_admin';

    protected $fillable = ['nama_admin', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function websites(): HasMany
    {
        return $this->hasMany(Website::class, 'id_admin', 'id_admin');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'id_admin', 'id_admin');
    }
}
