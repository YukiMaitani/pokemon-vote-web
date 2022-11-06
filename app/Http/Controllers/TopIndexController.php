<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopIndexController extends Controller
{
    function index() {
        return view('top_index');
    }
}
