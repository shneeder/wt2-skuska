<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('documentation');
    }
}
