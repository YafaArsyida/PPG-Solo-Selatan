<?php

namespace App\Http\Controllers\TemanPengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperasionalKegiatanPengurus extends Controller
{
    public function index()
    {
        return view('TEMANPENGURUS.OPERASIONAL.kegiatan-pengurus.v_index');
    }

    public function kartu($token)
    {
        return view('TEMANPENGURUS.OPERASIONAL.presensi-kegiatan.v_index', [
            'token' => $token
        ]);
    }
    public function manual($token)
    {
        return view('TEMANPENGURUS.OPERASIONAL.presensi-kegiatan.v_index', [
            'token' => $token
        ]);
    }
}
