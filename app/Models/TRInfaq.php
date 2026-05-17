<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TRInfaq extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tr_infaq';

    protected $primaryKey = 'tr_infaq_id';

    protected $fillable = [
        'ms_kegiatan_id',
        'ms_pengguna_id',
        'nominal',
        'tanggal',
        'keterangan',
    ];

    public function ms_kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'ms_kegiatan_id');
    }

    public function ms_pengguna()
    {
        return $this->belongsTo(User::class, 'ms_pengguna_id');
    }
}
