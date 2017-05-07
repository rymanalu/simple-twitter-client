<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Display a welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('welcome');
    }
}
