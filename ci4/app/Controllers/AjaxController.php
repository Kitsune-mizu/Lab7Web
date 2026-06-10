<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        return view('ajax/index');
    }

    public function getData()
    {
        $model = new ArtikelModel();
        $data  = $model->findAll();

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function getById($id)
    {
        $model = new ArtikelModel();
        $data  = $model->find($id);

        return $this->response->setJSON($data);
    }

    public function save()
    {
        $model  = new ArtikelModel();
        $judul  = $this->request->getPost('judul');
        $isi    = $this->request->getPost('isi');

        $model->save([
            'judul' => $judul,
            'isi'   => $isi,
        ]);

        return $this->response->setJSON(['status' => 'OK', 'message' => 'Data berhasil ditambahkan']);
    }

    public function update($id)
    {
        $model = new ArtikelModel();
        $judul = $this->request->getPost('judul');
        $isi   = $this->request->getPost('isi');

        $model->update($id, [
            'judul' => $judul,
            'isi'   => $isi,
        ]);

        return $this->response->setJSON(['status' => 'OK', 'message' => 'Data berhasil diubah']);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        $data = ['status' => 'OK'];

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }
}