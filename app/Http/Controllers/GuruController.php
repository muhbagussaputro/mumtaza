<?php

namespace App\Http\Controllers;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }
}
