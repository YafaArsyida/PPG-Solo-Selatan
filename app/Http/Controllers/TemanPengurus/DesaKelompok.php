<?php

namespace App\Http\Controllers\TemanPengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesaKelompok extends Controller
{
    public function index()
    {
        return view('TEMANPENGURUS.ADMINISTRASI.desa-kelompok.v_index');
    }
}
