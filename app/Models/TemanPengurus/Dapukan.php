<?php

namespace App\Models\TemanPengurus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dapukan extends Model
{
    use HasFactory;

    protected $table = 'ms_dapukan';

    protected $primaryKey = 'ms_dapukan_id';

    protected $fillable = [
        'nama_dapukan',
        'deskripsi',
    ];
}
