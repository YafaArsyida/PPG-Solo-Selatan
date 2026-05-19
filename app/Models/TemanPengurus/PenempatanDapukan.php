<?php

namespace App\Models\TemanPengurus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenempatanDapukan extends Model
{
    use HasFactory;

    protected $table = 'ms_penempatan_dapukan';

    protected $primaryKey = 'ms_penempatan_dapukan_id';

    protected $fillable = [
        'ms_pengurus_id',
        'ms_dapukan_id',
        'nama_penempatan',
        'status',
        'deskripsi',
    ];

    public function ms_pengurus()
    {
        return $this->belongsTo(Pengurus::class, 'ms_pengurus_id', 'ms_pengurus_id');
    }
    public function ms_dapukan()
    {
        return $this->belongsTo(Dapukan::class, 'ms_dapukan_id', 'ms_dapukan_id');
    }
}
