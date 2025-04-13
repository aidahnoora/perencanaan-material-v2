<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBom;
use App\Models\ModelBomDetail;
use App\Models\ModelMaterial;
use App\Models\ModelProduk;

class Bom extends BaseController
{
    protected $ModelBom;
    protected $ModelBomDetail;
    protected $ModelProduk;
    protected $ModelMaterial;

    public function __construct()
    {
        $this->ModelBom = new ModelBom();
        $this->ModelBomDetail = new ModelBomDetail();
        $this->ModelProduk = new ModelProduk();
        $this->ModelMaterial = new ModelMaterial();
    }

    public function index()
    {
        $boms = $this->ModelBom->AllData();

        foreach ($boms as &$bom) {
            $bom['bom_details'] = $this->ModelBomDetail->getBomDetailsByBomId($bom['id_bom']);
        }

        $data = [
            'judul' => 'BOM',
            'subjudul' => '',
            'menu' => 'bom',
            'submenu' => '',
            'page' => 'admin/v_bom',
            'products' => $this->ModelProduk->AllData(),
            'materials' => $this->ModelMaterial->AllData(),
            'boms' => $boms,
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        // if (!$this->validate([
        //     'product_id' => 'required',
        //     'materials'  => 'required',
        //     'quantities' => 'required'
        // ])) {
        //     return redirect()->to('Bom')->withInput()->with('errors', $this->validator->getErrors());
        // }

        // Insert data BOM
        $dataBom = [
            'product_id' => $this->request->getPost('product_id'),
            'bom_code' => $this->request->getPost('bom_code'),
            'effective_date' => $this->request->getPost('effective_date'),
            'bom_version' => $this->request->getPost('bom_version'),
            'approved_by' => $this->request->getPost('approved_by'),
            'notes' => $this->request->getPost('notes'),
        ];
        $this->ModelBom->insert($dataBom);
        $bom_id = $this->ModelBom->insertID();

        // Insert data BOM Details
        $materials = $this->request->getPost('material_id');
        $quantities = $this->request->getPost('quantity_needed');
        $levels = $this->request->getPost('level');
        $proces_notes = $this->request->getPost('proces_notes');

        $dataBomDetails = [];
        foreach ($materials as $key => $material_id) {
            $dataBomDetails[] = [
                'bom_id' => $bom_id,
                'material_id' => $material_id,
                'quantity_needed' => $quantities[$key],
                'level' => $levels[$key],
                'proces_notes' => $proces_notes[$key]
            ];
        }
        $this->ModelBomDetail->insertBatch($dataBomDetails);

        session()->setFlashdata('pesan', 'Data BOM dan BOM Detail Berhasil Ditambahkan!');
        return redirect()->to('Bom');
    }

    public function UpdateData($id)
    {
        // Validasi (Opsional)
        if (!$this->validate([
            'product_id' => 'required',
            'material_id'  => 'required',
            'quantity_needed' => 'required',
            'level' => 'required',
            'proces_notes' => 'required',
        ])) {
            return redirect()->to('Bom')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data BOM
        $dataBom = [
            'product_id' => $this->request->getPost('product_id'),
            'bom_code' => $this->request->getPost('bom_code'),
            'effective_date' => $this->request->getPost('effective_date'),
            'bom_version' => $this->request->getPost('bom_version'),
            'approved_by' => $this->request->getPost('approved_by'),
            'notes' => $this->request->getPost('notes'),
        ];
        $this->ModelBom->update($id, $dataBom);

        // Hapus detail lama
        $this->ModelBomDetail->where('bom_id', $id)->delete();

        // Ambil data dari form
        $materials = $this->request->getPost('material_id');  // Sesuai dengan modal edit
        $quantities = $this->request->getPost('quantity_needed');  // Sesuai dengan modal edit
        $levels = $this->request->getPost('level');
        $proces_notes = $this->request->getPost('proces_notes');

        // Simpan detail BOM baru
        $dataBomDetails = [];
        foreach ($materials as $key => $material_id) {
            $dataBomDetails[] = [
                'bom_id' => $id,
                'material_id' => $material_id,
                'quantity_needed' => $quantities[$key],
                'level' => $levels[$key],
                'proces_notes' => $proces_notes[$key]
            ];
        }

        if (!empty($dataBomDetails)) {
            $this->ModelBomDetail->insertBatch($dataBomDetails);
        }

        session()->setFlashdata('pesan', 'Data BOM dan BOM Detail Berhasil Diperbarui!');
        return redirect()->to('Bom');
    }

    public function DeleteData($id)
    {
        // Hapus detail dulu baru hapus BOM utama
        $this->ModelBomDetail->where('bom_id', $id)->delete();
        $this->ModelBom->delete($id);

        session()->setFlashdata('pesan', 'Data BOM Berhasil Dihapus!');
        return redirect()->to('Bom');
    }
}
