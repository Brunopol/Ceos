<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ControleDeAcesso extends Controller
{


    function index(): View
    {
        return view('ControleDeAcesso');
    }


}