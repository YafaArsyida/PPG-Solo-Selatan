<?php

namespace App\Http\Controllers\TemanPengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Pengurus extends Controller
{
    public function index()
    {
        return view('TEMANPENGURUS.ADMINISTRASI.pengurus.v_index');
    }
}
