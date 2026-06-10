<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title'   => 'Halaman About',
            'content' => 'Ini adalah halaman About yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title'   => 'Halaman Contact',
            'content' => 'Ini adalah halaman Contact. Silakan hubungi kami melalui email atau nomor telepon yang tersedia.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title'   => 'Halaman FAQ',
            'content' => 'Ini adalah halaman FAQ (Frequently Asked Questions) yang berisi pertanyaan-pertanyaan yang sering diajukan.'
        ]);
    }

    public function tos()
    {
        return view('tos', [
            'title'   => 'Term of Services',
            'content' => 'Ini adalah halaman Term of Services yang berisi syarat dan ketentuan penggunaan layanan kami.'
        ]);
    }
}