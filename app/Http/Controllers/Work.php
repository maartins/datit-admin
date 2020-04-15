<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class Work extends Controller
{
    public function index() {
        return view('work');
    }
}
