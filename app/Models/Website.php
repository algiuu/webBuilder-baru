<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    protected $primaryKey = 'id_website';

    protected $fillable = ['id_admin', 'id_template', 'nama_website', 'bio', 'slug', 'logo', 'foto_pribadi', 'contact', 'status', 'visit_count', 'last_visited_at'];

    protected function casts(): array
    {
        return ['last_visited_at' => 'datetime'];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'id_template', 'id_template');
    }

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_website', 'id_website');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(WebsiteGallery::class, 'id_website', 'id_website')->orderBy('urutan');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(WebsiteContact::class, 'id_website', 'id_website');
    }
}
