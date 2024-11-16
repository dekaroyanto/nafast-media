<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorHandlerController extends Controller
{
    public function notfound()
    {
        return view('ErrorHandler.404');
    }
}
