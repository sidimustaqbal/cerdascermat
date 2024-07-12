<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('scoreboard');
    }

    function operator(): string
    {
        return view('operator');
    }
}
