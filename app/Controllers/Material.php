<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;

class Material extends BaseController
{
    protected $ModelMaterial;

    public function __construct()
    {
        $this->ModelMaterial = new ModelMaterial();
    }

    public function index($type = 'raw') // default ke 'raw' jika tidak ada parameter
    {
        // Mapping type ke view
        $viewMap = [
            'raw'    => 'admin/v_material',
            'tahap1' => 'admin/v_hasil_tahap1',
            'tahap2' => 'admin/v_hasil_tahap2',
            'tahap3' => 'admin/v_hasil_tahap3',
            'tahap4' => 'admin/v_hasil_tahap4',
        ];

        // Cek apakah type valid, jika tidak default ke 'raw'
        if (!array_key_exists($type, $viewMap)) {
            $type = 'raw';
        }

        $data = [
            'judul' => 'Material',
            'subjudul' => '',
            'menu' => 'material',
            'submenu' => '',
            'page' => $viewMap[$type],
            'materials' => $this->ModelMaterial->where('type', $type)->findAll(),
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        $type = $this->request->getPost('type');

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
            'type' => $type,
            'source_process_step_id' => $this->request->getPost('source_process_step_id')
        ];
        $this->ModelMaterial->InsertData($data);

        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        // return redirect()->to('Material');
        return redirect()->to('Material/index/' . $type);
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

        return redirect()->back();
    }

    public function DeleteData($id_material)
    {
        $data = [
            'id_material' => $id_material,
        ];
        $this->ModelMaterial->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');

        return redirect()->back();
    }
}
