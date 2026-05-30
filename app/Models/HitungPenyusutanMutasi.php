<?php

namespace App\Models;

use App\Models\AsetUtama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HitungPenyusutanMutasi extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function aset()
    {
        return $this->belongsTo(AsetUtama::class, 'aset_utama_id');
    }
}
