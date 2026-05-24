<?php

namespace App\Models\TemanPengurus;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TRInfaqPengurus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tr_infaq_pengurus';

    protected $primaryKey = 'tr_infaq_pengurus_id';

    protected $fillable = [
        'ms_kegiatan_pengurus_id',
        'ms_pengguna_id',
        'nominal',
        'tanggal',
        'keterangan',
    ];

    public function ms_kegiatan_pengurus()
    {
        return $this->belongsTo(KegiatanPengurus::class, 'ms_kegiatan_pengurus_id');
    }

    public function ms_pengguna()
    {
        return $this->belongsTo(User::class, 'ms_pengguna_id');
    }
}
