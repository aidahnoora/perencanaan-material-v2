<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSupplier;
class Supplier extends BaseController
{
    public function __construct()
    {
        $this->ModelSupplier = new ModelSupplier();
    }

    public function index()
    {
        $data = [
            'judul' => 'Supplier',
            'subjudul' => '',
            'menu' => 'supplier',
            'submenu' => '',
            'page' => 'admin/v_supplier',
            'suppliers' => $this->ModelSupplier->AllData(),
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        $data = [
            'supplier_code' => $this->request->getPost('supplier_code'),
            'supplier_name' => $this->request->getPost('supplier_name'),
            'material_category' => $this->request->getPost('material_category'),
            'contact_person' => $this->request->getPost('contact_person'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
        ];
        $this->ModelSupplier->InsertData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');

        return redirect()->to('Supplier');
    }

    public function UpdateData($id_supplier)
    {
        $data = [
            'id_supplier' => $id_supplier,
            'supplier_code' => $this->request->getPost('supplier_code'),
            'supplier_name' => $this->request->getPost('supplier_name'),
            'material_category' => $this->request->getPost('material_category'),
            'contact_person' => $this->request->getPost('contact_person'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
        ];
        $this->ModelSupplier->UpdateData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');

        return redirect()->to('Supplier');
    }

    public function DeleteData($id_supplier)
    {
        $data = [
            'id_supplier' => $id_supplier,
        ];
        $this->ModelSupplier->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');

        return redirect()->to('Supplier');
    }
}
