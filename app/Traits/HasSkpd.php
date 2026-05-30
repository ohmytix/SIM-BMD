<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

trait HasSkpd
{
    protected static function bootHasSkpd()
    {
        // 1. GLOBAL SCOPE (Untuk Read/View)
        // Saat query dijalankan (AsetUtama::all()), otomatis filter berdasarkan Session SKPD
        static::addGlobalScope('skpd', function (Builder $builder) {
            if (Session::has('active_skpd_id')) {
                $builder->where('skpd_id', Session::get('active_skpd_id'));
            }
        });

        // 2. MODEL EVENT (Untuk Create)
        // Saat data disimpan (create), otomatis isi kolom skpd_id dari Session
        static::creating(function ($model) {
            if (Session::has('active_skpd_id')) {
                $model->skpd_id = Session::get('active_skpd_id');
            }
        });
    }

    // Definisi Relasi ke Tabel SKPD
    public function skpd()
    {
        return $this->belongsTo(\App\Models\Skpd::class, 'skpd_id');
    }
}