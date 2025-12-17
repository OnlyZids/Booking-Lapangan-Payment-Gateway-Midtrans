<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    function index()
    {
        $courts = \App\Models\Court::where('is_active', true)->get();
        return view('welcome', compact('courts'));
    }
}
