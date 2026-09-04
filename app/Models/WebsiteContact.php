<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteContact extends Model
{
    protected $fillable = ['id_website', 'platform', 'value'];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'id_website', 'id_website');
    }
}
