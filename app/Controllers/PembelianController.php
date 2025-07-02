<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class PembelianController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();

        if (session()->get('role') != 'admin') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan.');
        }
    }

    public function index()
    {
        helper('number');
        $pembelian = $this->transactionModel->orderBy('created_at', 'DESC')->findAll();
        $details = $this->transactionDetailModel
                        ->select('transaction_detail.*, product.nama, product.foto, product.harga as harga_asli')
                        ->join('product', 'product.id = transaction_detail.product_id')
                        ->findAll();
        
        $detail_produk = [];
        foreach ($details as $detail) {
            $detail_produk[$detail['transaction_id']][] = $detail;
        }

        $data = [
            'title'     => 'Manajemen Pembelian',
            'pembelian' => $pembelian,
            'detail'    => $detail_produk, 
        ];

        return view('v_pembelian', $data);
    }

    public function detail($id)
    {
        $transaksi = $this->transactionModel->find($id);

        if (!$transaksi) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan.']);
        }

        $details = $this->transactionDetailModel
                        ->select('transaction_detail.*, product.nama, product.foto, product.harga as harga_asli')
                        ->join('product', 'product.id = transaction_detail.product_id')
                        ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $details,
            'ongkir' => $transaksi['ongkir']
        ]);
    }

    public function ubahStatus($id)
    {
        $transaksi = $this->transactionModel->find($id);

        if ($transaksi) {
            $newStatus = ($transaksi['status'] == 0) ? 1 : 0;
            $this->transactionModel->update($id, ['status' => $newStatus]);
            
            session()->setFlashdata('success', 'Status pesanan berhasil diubah.');
        } else {
            session()->setFlashdata('failed', 'Data transaksi tidak ditemukan.');
        }

        return redirect()->to('/pembelian');
    }
}