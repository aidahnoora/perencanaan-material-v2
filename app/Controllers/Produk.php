<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProduk;

class Produk extends BaseController
{
    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
    }

    public function index()
    {
        $data = [
            'judul' => 'Produk',
            'subjudul' => '',
            'menu' => 'produk',
            'submenu' => '',
            'page' => 'admin/v_produk',
            'products' => $this->ModelProduk->AllData(),
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        $data = [
            'product_code' => $this->request->getPost('product_code'),
            'product_name' => $this->request->getPost('product_name'),
            'product_spec' => $this->request->getPost('product_spec'),
            'standard_cost' => $this->request->getPost('standard_cost'),
            'bom' => $this->request->getPost('bom'),
            'category' => $this->request->getPost('category'),
            'status' => $this->request->getPost('status'),
        ];
        $this->ModelProduk->InsertData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');

        return redirect()->to('Produk');
    }

    public function UpdateData($id_product)
    {
        $data = [
            'id_product' => $id_product,
            'product_code' => $this->request->getPost('product_code'),
            'product_name' => $this->request->getPost('product_name'),
            'product_spec' => $this->request->getPost('product_spec'),
            'standard_cost' => $this->request->getPost('standard_cost'),
            'bom' => $this->request->getPost('bom'),
            'category' => $this->request->getPost('category'),
            'status' => $this->request->getPost('status'),
        ];
        $this->ModelProduk->UpdateData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');

        return redirect()->to('Produk');
    }

    public function DeleteData($id_product)
    {
        $data = [
            'id_product' => $id_product,
        ];
        $this->ModelProduk->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');

        return redirect()->to('Produk');
    }
}
