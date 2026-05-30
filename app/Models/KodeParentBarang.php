<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeParentBarang extends Model
{
    protected $table = 'kode_parent_barang';
    protected $fillable = ['kode', 'uraian'];
    public $timestamps = false;
}
