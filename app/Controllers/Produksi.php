<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBomDetail;
use App\Models\ModelEksekusiStok;
use App\Models\ModelMaterial;
use App\Models\ModelOrderProduksi;
use App\Models\ModelProduk;
use App\Models\ModelProduksi;
use App\Models\ModelStruktur;

class Produksi extends BaseController
{
    protected $ModelProduk;
    protected $ModelProduksi;
    protected $ModelBomDetail;
    protected $ModelStruktur;
    protected $ModelMaterial;
    protected $ModelOrderProduksi;
    protected $ModelEksekusiStok;

    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelProduksi = new ModelProduksi();
        $this->ModelBomDetail = new ModelBomDetail();
        $this->ModelStruktur = new ModelStruktur();
        $this->ModelMaterial = new ModelMaterial();
        $this->ModelOrderProduksi = new ModelOrderProduksi();
        $this->ModelEksekusiStok = new ModelEksekusiStok();
    }

    public function index()
    {
        $productions = $this->ModelProduksi->AllData();

        foreach ($productions as &$production) {
            $production['material_requirements'] = $this->ModelStruktur->getMaterialRequirementByProductionId($production['id'], 1);
            $production['materials2'] = $this->ModelStruktur->getMaterialRequirementByProductionId($production['id'], 2);
            $production['materials3'] = $this->ModelStruktur->getMaterialRequirementByProductionId($production['id'], 3);
            $production['materials4'] = $this->ModelStruktur->getMaterialRequirementByProductionId($production['id'], 4);

            $production['bom_id'] = !empty($production['material_requirements']) ? $production['material_requirements'][0]['bom_id'] : null;
            $production['bom_id_2'] = !empty($production['materials2']) ? $production['materials2'][0]['bom_id'] : null;
            $production['bom_id_3'] = !empty($production['materials3']) ? $production['materials3'][0]['bom_id'] : null;
            $production['bom_id_4'] = !empty($production['materials4']) ? $production['materials4'][0]['bom_id'] : null;

            $executionStock = $production['execution_stock'] = $this->ModelEksekusiStok->getExecutionStocksByPlanningId($production['id']);
            
            if (!empty($executionStock)) {
                $production['execution_stocks'] = $executionStock;
            } else {
                continue;
            }

            if (!empty($production['bom_id_2'])) {
                $production['bom_id_2'] = $production['bom_id_2'];
            } else {
                continue;
            }

            // dd($production['materials2']);
        }

        $data = [
            'judul' => 'Produksi',
            'subjudul' => '',
            'menu' => 'produksi',
            'submenu' => '',
            'page' => 'admin/v_produksi',
            'products' => $this->ModelProduk->AllData(),
            'productions' => $productions,
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'product_id' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
            'quality' => [
                'label' => 'Jumlah Produksi',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                    'numeric' => '{field} Harus Angka!',
                ]
            ]
        ])) {
            $db = \Config\Database::connect();
            $db->transStart();

            try {
                $boms = $db->table('boms')
                    ->select('id_bom, process_step_id')
                    ->where('product_id', $this->request->getPost('product_id'))
                    // ->where('process_step_id', 1) 
                    // ->limit(1)
                    ->get()
                    ->getResultArray();

                // dd($bom['id_bom']);

                if (!$boms) {
                    throw new \Exception("BOM tidak ditemukan untuk produk ini.");
                }

                // 1. Simpan data produksi
                $dataProduksi = [
                    'product_id' => $this->request->getPost('product_id'),
                    // 'bom_id' => $bom['id_bom'],
                    'planned_date' => $this->request->getPost('planned_date'),
                    'quality' => $this->request->getPost('quality'),
                    'priority' => $this->request->getPost('priority'),
                    'status_production' => $this->request->getPost('status_production'),
                    'notes' => $this->request->getPost('notes'),
                ];
                $productionId = $this->ModelProduksi->insert($dataProduksi);

                if (!$productionId) {
                    throw new \Exception("Gagal menyimpan data produksi.");
                }

                // 2. Ambil BOM produk
                foreach ($boms as $bom) {
                    $bomDetails = $this->ModelBomDetail
                        ->select('material_id, quantity_needed')
                        ->where('bom_id', $bom['id_bom'])
                        ->findAll();
                
                    foreach ($bomDetails as $bomDetail) {
                        $stok = $this->ModelMaterial->find($bomDetail['material_id']);
                        $grossRequirement = $bomDetail['quantity_needed'] * $this->request->getPost('quality');
                        $netRequirement = max(0, $grossRequirement - $stok['max_stock']);
                
                        if ($netRequirement == 0) {
                            $status = 'fullfiled';
                        } elseif ($netRequirement > 0 && $stok['max_stock'] > 0) {
                            $status = 'partially';
                        } else {
                            $status = 'pending';
                        }
                
                        $this->ModelStruktur->insert([
                            'production_planning_id' => $productionId,
                            'material_id' => $bomDetail['material_id'],
                            'gross_requirement' => $grossRequirement,
                            'net_requirement' => $netRequirement,
                            'status_material_requirement' => $status,
                            'bom_id' => $bom['id_bom'],
                            'process_step_id' => $bom['process_step_id'],
                        ]);
                    }
                }                

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \Exception("Terjadi kesalahan saat menyimpan data.");
                }

                session()->setFlashdata('pesan', 'Produksi dan kebutuhan material berhasil ditambahkan!');
                return redirect()->to(base_url('Produksi'));
            } catch (\Exception $e) {
                $db->transRollback();
                session()->setFlashdata('errors', [$e->getMessage()]);
                return redirect()->to(base_url('Produksi'))->withInput();
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Produksi'))->withInput();
        }
    }

    public function updateRequirement($productionId)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Ambil semua material yang dibutuhkan untuk produksi ini
            $requirements = $this->ModelStruktur
                ->where('production_planning_id', $productionId)
                ->findAll();

            foreach ($requirements as $req) {
                $materialId = $req['material_id'];

                // 2. Ambil stok terbaru dari tabel material
                $material = $this->ModelMaterial->find($materialId);
                $stok = $material['max_stock'];

                $grossRequirement = $req['gross_requirement'];
                $netRequirement = max(0, $grossRequirement - $stok);

                // 3. Tentukan status requirement
                if ($netRequirement == 0) {
                    $status = 'fullfiled';
                } elseif ($netRequirement > 0 && $stok > 0) {
                    $status = 'partially';
                } else {
                    $status = 'pending';
                }

                // 4. Update ke tabel material_requirements
                $this->ModelStruktur->update($req['id_material_requirement'], [
                    'net_requirement' => $netRequirement,
                    'status_material_requirement' => $status
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Gagal memperbarui kebutuhan material.");
            }

            session()->setFlashdata('pesan', 'Status dan kebutuhan material berhasil diperbarui!');
            return redirect()->to(base_url('Produksi'));
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->to(base_url('Produksi'));
        }
    }

    public function UpdateData($id)
    {
        if ($this->validate([
            'product_id' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
        ])) {
            $data = [
                'id' => $id,
                'planned_date' => $this->request->getPost('planned_date'),
                'quality' => $this->request->getPost('quality'),
                'priority' => $this->request->getPost('priority'),
                'status_production' => $this->request->getPost('status_production'),
                'notes' => $this->request->getPost('notes'),
            ];
            $this->ModelProduksi->UpdateData($data);

            session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
            return redirect()->to(base_url('Produksi'));
        } else {
            session()->setFlashdata('pesan', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Produksi'))->withInput('validation', \Config\Services::validation());
        }
    }

    public function DeleteData($id)
    {
        $data = [
            'id' => $id
        ];
        $this->ModelProduksi->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('Produksi');
    }
}
