<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $primaryKey = 'id_template';

    protected $fillable = ['nama_template', 'jumlah_template', 'status'];

    public function websites(): HasMany
    {
        return $this->hasMany(Website::class, 'id_template', 'id_template');
    }
}
