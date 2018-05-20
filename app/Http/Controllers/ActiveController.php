<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;

class ActiveController extends Controller
{
    public function index()
    {
        return view('active');
    }
}
