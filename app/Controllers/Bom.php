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

    public function index($step_id = null)
    {
        if ($step_id !== null) {
            $boms = $this->ModelBom->getByStep($step_id);
        } else {
            $boms = $this->ModelBom->AllData();
        }

        foreach ($boms as &$bom) {
            $bom['bom_details'] = $this->ModelBomDetail->getBomDetailsByBomId($bom['id_bom']);
        }

        // Tentukan view sesuai tahap
        $viewMap = [
            1 => 'admin/v_bom_tahap1',
            2 => 'admin/v_bom_tahap2',
            3 => 'admin/v_bom_tahap3',
            4 => 'admin/v_bom_tahap4',
        ];

        // Filter material berdasarkan step_id
        $materialTypes = ['raw'];
        if ($step_id >= 2) $materialTypes[] = 'tahap1';
        if ($step_id >= 3) $materialTypes[] = 'tahap2';
        if ($step_id >= 4) $materialTypes[] = 'tahap3';

        if ($step_id !== null) {
            $materials = $this->ModelMaterial->whereIn('type', $materialTypes)->findAll();
            $materialhasils = $this->ModelMaterial->where('source_process_step_id', $step_id)->findAll();
        } else {
            $materials = $this->ModelMaterial->findAll(); // default semua jika tidak ada step
            $materialhasils = null;
        }


        $data = [
            'judul' => 'BOM',
            'subjudul' => '',
            'menu' => 'bom',
            'submenu' => '',
            'page' => $step_id && isset($viewMap[$step_id]) ? $viewMap[$step_id] : 'admin/v_bom',
            'products' => $this->ModelProduk->AllData(),
            'materials' => $materials,
            'materialhasils' => $materialhasils,
            'boms' => $boms,
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        $step_id = $this->request->getPost('process_step_id');
        // Insert data BOM
        $dataBom = [
            'product_id' => $this->request->getPost('product_id'),
            'material_hasil_id' => $this->request->getPost('material_hasil_id'),
            'process_step_id' => $step_id,
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
        return redirect()->to('Bom/index/' . $step_id);
    }

    public function UpdateData($id, $step_id)
    {
        if (!$this->validate([
            'product_id' => 'required',
            'material_id'  => 'required',
            'quantity_needed' => 'required',
            'level' => 'required',
            'proces_notes' => 'required',
        ])) {
            return redirect()->to('Bom/index/' . $step_id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data BOM
        $dataBom = [
            'product_id' => $this->request->getPost('product_id'),
            'material_hasil_id' => $this->request->getPost('material_hasil_id'),
            'bom_code' => $this->request->getPost('bom_code'),
            'effective_date' => $this->request->getPost('effective_date'),
            'bom_version' => $this->request->getPost('bom_version'),
            'approved_by' => $this->request->getPost('approved_by'),
            'notes' => $this->request->getPost('notes'),
            'process_step_id' => $step_id,
        ];
        $this->ModelBom->update($id, $dataBom);

        // Hapus dan masukkan kembali detail
        $this->ModelBomDetail->where('bom_id', $id)->delete();

        $materials = $this->request->getPost('material_id');
        $quantities = $this->request->getPost('quantity_needed');
        $levels = $this->request->getPost('level');
        $proces_notes = $this->request->getPost('proces_notes');

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
        return redirect()->to('Bom/index/' . $step_id);
    }


    public function DeleteData($id, $step_id)
    {
        $this->ModelBomDetail->where('bom_id', $id)->delete();
        $this->ModelBom->delete($id);

        session()->setFlashdata('pesan', 'Data BOM Berhasil Dihapus!');
        return redirect()->to('Bom/index/' . $step_id);
    }
}
