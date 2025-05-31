<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KategoriProdukModel;

class KategoriProdukController extends Controller
{
    protected $KategoriProdukModel;

    public function __construct()
    {
        $this->KategoriProdukModel = new KategoriProdukModel();
    }

    public function index()
    {
        $data['kategori'] = $this->KategoriProdukModel->findAll();
        return view('v_produk_kategori', $data);
    }

    public function create()
    {
        $this->KategoriProdukModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('kategori');
    }

    public function edit($id)
    {
        $data['kategori'] = $this->KategoriProdukModel->find($id);
        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        $this->KategoriProdukModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('kategori');
    }

    public function delete($id)
    {
        $this->KategoriProdukModel->delete($id);
        return redirect()->to('kategori');
    }
}
