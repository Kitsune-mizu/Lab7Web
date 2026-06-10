<?php

namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function index()
    {
        $model   = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();

        return view('components/artikel_terkini', [
            'artikel' => $artikel,
        ]);
    }
}