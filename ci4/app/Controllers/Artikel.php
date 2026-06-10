<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel; // Panggil KategoriModel
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel(); 

        // Ambil artikel beserta nama kategorinya
        $artikel = $model->select('artikel.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                        ->findAll();
                        
        // Ambil semua data kategori untuk ditampilkan di sidebar halaman depan
        $kategori = $kategoriModel->findAll();

        return view('artikel/index', compact('artikel', 'title', 'kategori'));
    }

    // ==========================================
    // TUGAS 4: Fungsi filter berdasarkan kategori
    // ==========================================
    public function kategori($id_kategori)
    {
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();
        
        // Cek apakah kategori ada
        $kat = $kategoriModel->find($id_kategori);
        if (!$kat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $title = 'Kategori: ' . $kat['nama_kategori'];
        
        // Ambil artikel hanya yang memiliki id_kategori yang dipilih
        $artikel = $model->select('artikel.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                        ->where('artikel.id_kategori', $id_kategori)
                        ->findAll();
                        
        // Tetap ambil semua kategori untuk menu sidebar
        $kategori = $kategoriModel->findAll();

        return view('artikel/index', compact('artikel', 'title', 'kategori'));
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->select('artikel.*, kategori.nama_kategori')
                         ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                         ->where(['slug' => $slug])
                         ->first();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    public function admin_index()
{
    $title       = 'Daftar Artikel (Admin)';
    $model       = new ArtikelModel();
    $q           = $this->request->getVar('q')           ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $page        = $this->request->getVar('page')        ?? 1;

    $builder = $model->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

    if ($q != '') {
        $builder->like('artikel.judul', $q);
    }

    if ($kategori_id != '') {
        $builder->where('artikel.id_kategori', $kategori_id);
    }

    $artikel = $builder->paginate(2, 'default', $page); // ← 2 per halaman untuk testing
    $pager   = $model->pager;

    if ($this->request->isAJAX()) {
        $totalRows   = $pager->getTotal();
        $perPage     = $pager->getPerPage();
        $totalPages  = (int) ceil($totalRows / $perPage);
        $currentPage = (int) $page;

        // Selalu buat links meski hanya 1 halaman
        $links = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $links[] = [
                'url'    => "/admin/artikel?page={$i}&q={$q}&kategori_id={$kategori_id}",
                'title'  => (string) $i,
                'active' => ($i === $currentPage),
            ];
        }

        return $this->response->setJSON([
            'title'       => $title,
            'q'           => $q,
            'kategori_id' => $kategori_id,
            'artikel'     => $artikel,
            'pager'       => [
                'links'      => $links,
                'totalRows'  => $totalRows,
                'totalPages' => $totalPages,
                'currentPage'=> $currentPage,
            ],
        ]);
    } else {
        $kategoriModel    = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        $data['title']       = $title;
        $data['q']           = $q;
        $data['kategori_id'] = $kategori_id;
        $data['artikel']     = $artikel;
        $data['pager']       = $pager;
        return view('artikel/admin_index', $data);
    }
}

    public function dashboard()
    {
        $title   = "Dashboard Admin";
        $model   = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/admin_dashboard', compact('title', 'artikel'));
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul'       => 'required',
            'id_kategori' => 'required' 
        ]);

        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            // Logika upload gambar digabungkan ke sini
            $file = $this->request->getFile('gambar');
            $nama_gambar = '';

            // Pengecekan jika file gambar diupload
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $file->move(ROOTPATH . 'public/gambar');
                $nama_gambar = $file->getName();
            }

            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'), 
                'slug'        => url_title($this->request->getPost('judul'), '-', true),
                'gambar'      => $nama_gambar // Menyimpan nama file gambar ke database
            ]);
            return redirect()->to('/admin/artikel');
        }

        $kategoriModel = new KategoriModel();
        $title = "Tambah Artikel";
        $kategori = $kategoriModel->findAll(); 

        return view('artikel/form_add', compact('title', 'kategori'));
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul'       => 'required',
            'id_kategori' => 'required'
        ]);

        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            // Data awal yang akan diupdate
            $dataUpdate = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ];

            // Cek apakah ada upload gambar baru saat edit
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $file->move(ROOTPATH . 'public/gambar');
                $dataUpdate['gambar'] = $file->getName(); // Tambahkan gambar ke data update jika ada
            }

            $artikel->update($id, $dataUpdate);
            return redirect()->to('/admin/artikel');
        }

        $data = $artikel->where('id', $id)->first();
        $kategori = $kategoriModel->findAll();
        $title = "Edit Artikel";

        return view('artikel/form_edit', compact('title', 'data', 'kategori'));
    }

    public function delete($id)  
    { 
        $artikel = new ArtikelModel(); 
        $artikel->delete($id); 
        return redirect()->to('/admin/artikel'); 
    } 
}