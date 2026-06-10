<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $title   = 'Halaman Home';
        $content = 'Selamat datang di website Portal Berita. 
                    Temukan berbagai artikel menarik di sini.';

        return view('home', compact('title', 'content'));
    }
}