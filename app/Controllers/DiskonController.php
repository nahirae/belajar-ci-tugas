<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Diskon',
            'diskon' => $this->diskonModel->orderBy('tanggal', 'DESC')->findAll(),
        ];

        return view('v_diskon', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Diskon',
        ];

        return view('v_diskon_create', $data);
    }

    public function store()
    {
        $rules = [
            'tanggal' => [
                'rules' => 'required|is_unique[diskon.tanggal]',
                'errors' => [
                    'required' => 'Tanggal harus diisi.',
                    'is_unique' => 'Diskon untuk tanggal ini sudah ada.'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi.',
                    'numeric' => 'Nominal harus berupa angka.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->diskonModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ]);

        session()->setFlashdata('success', 'Data diskon berhasil ditambahkan.');
        return redirect()->to('/diskon');
    }

    public function edit($id = null)
    {
        $data = [
            'title'  => 'Edit Data Diskon',
            'diskon' => $this->diskonModel->find($id),
        ];

        if (empty($data['diskon'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data diskon tidak ditemukan.');
        }

        return view('v_diskon_edit', $data);
    }

    public function update($id = null)
    {
        // Aturan validasi
        $rules = [
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi.',
                    'numeric' => 'Nominal harus berupa angka.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->diskonModel->update($id, [
            'nominal' => $this->request->getPost('nominal'),
        ]);

        session()->setFlashdata('success', 'Data diskon berhasil diperbarui.');
        return redirect()->to('/diskon');
    }

    public function delete($id = null)
    {
        $this->diskonModel->delete($id);
        session()->setFlashdata('success', 'Data diskon berhasil dihapus.');
        return redirect()->to('/diskon');
    }
}