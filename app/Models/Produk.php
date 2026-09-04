<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $primaryKey = 'id_produk';

    protected $fillable = ['id_website', 'nama_produk', 'deskripsi_produk', 'foto_produk', 'harga', 'jumlah_produk'];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'id_website', 'id_website');
    }
}
