<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerolehanPenambahan extends Model
{
    use HasFactory;
    protected $guarded =["id"];

    public function AsetUtama(): BelongsTo
    {
        return $this->belongsTo(AsetUtama::class);
    }
}
