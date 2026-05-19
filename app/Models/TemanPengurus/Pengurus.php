<?php

namespace App\Models\TemanPengurus;

use App\Models\Kelompok;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengurus extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'ms_pengurus';

    protected $primaryKey = 'ms_pengurus_id';

    protected $fillable = [
        'ms_kelompok_id',
        'nama_pengurus',
        'kode_pengurus',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'deskripsi',
    ];

    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir
            ? Carbon::parse($this->tanggal_lahir)->age
            : null;
    }

    public function ms_kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'ms_kelompok_id', 'ms_kelompok_id');
    }
    public function ms_penempatan_dapukan()
    {
        return $this->hasMany(PenempatanDapukan::class,'ms_pengurus_id', 'ms_pengurus_id');
    }
}
