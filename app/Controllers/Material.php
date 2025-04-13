<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;

class Material extends BaseController
{
    public function __construct()
    {
        $this->ModelMaterial = new ModelMaterial();
    }

    public function index()
    {
        $data = [
            'judul' => 'Material',
            'subjudul' => '',
            'menu' => 'material',
            'submenu' => '',
            'page' => 'admin/v_material',
            'materials' => $this->ModelMaterial->AllData(),
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        $data = [
            'material_code' => $this->request->getPost('material_code'),
            'material_name' => $this->request->getPost('material_name'),
            'material_spec' => $this->request->getPost('material_spec'),
            'material_type' => $this->request->getPost('material_type'),
            'grade' => $this->request->getPost('grade'),
            'standard_cost' => $this->request->getPost('standard_cost'),
            'bom' => $this->request->getPost('bom'),
            'min_stock' => $this->request->getPost('min_stock'),
            'max_stock' => $this->request->getPost('max_stock'),
            'status' => $this->request->getPost('status'),
        ];
        $this->ModelMaterial->InsertData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');

        return redirect()->to('Material');
    }

    public function UpdateData($id_material)
    {
        $data = [
            'id_material' => $id_material,
            'material_code' => $this->request->getPost('material_code'),
            'material_name' => $this->request->getPost('material_name'),
            'material_spec' => $this->request->getPost('material_spec'),
            'material_type' => $this->request->getPost('material_type'),
            'grade' => $this->request->getPost('grade'),
            'standard_cost' => $this->request->getPost('standard_cost'),
            'bom' => $this->request->getPost('bom'),
            'min_stock' => $this->request->getPost('min_stock'),
            'max_stock' => $this->request->getPost('max_stock'),
            'status' => $this->request->getPost('status'),
        ];
        $this->ModelMaterial->UpdateData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');

        return redirect()->to('Material');
    }

    public function DeleteData($id_material)
    {
        $data = [
            'id_material' => $id_material,
        ];
        $this->ModelMaterial->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');

        return redirect()->to('Material');
    }
}
