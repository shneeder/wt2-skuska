<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;

class WorktableController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('worktable');
    }
}
