<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChaveController extends Controller
{
    public function index()
    {
        return view('chaves');
    }
}
