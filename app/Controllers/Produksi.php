<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBomDetail;
use App\Models\ModelProduk;
use App\Models\ModelProduksi;
use App\Models\ModelStruktur;

class Produksi extends BaseController
{
    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelProduksi = new ModelProduksi();
        $this->ModelBomDetail = new ModelBomDetail();
        $this->ModelStruktur = new ModelStruktur();
    }

    public function index()
    {
        $data = [
            'judul' => 'Produksi',
            'subjudul' => '',
            'menu' => 'produksi',
            'submenu' => '',
            'page' => 'admin/v_produksi',
            'products' => $this->ModelProduk->AllData(),
            'productions' => $this->ModelProduksi->AllData(),
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
            $db->transStart(); // Mulai transaksi

            try {
                // Simpan data produksi
                $dataProduksi = [
                    'product_id' => $this->request->getPost('product_id'),
                    'order_number' => $this->request->getPost('order_number'),
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

                // Ambil BOM berdasarkan produk
                $bomModel = $this->ModelBomDetail;
                $bomDetails = $bomModel->select('material_id, quantity_needed')
                    ->whereIn('bom_id', function ($builder) {
                        return $builder->select('id_bom')
                            ->from('boms')
                            ->where('product_id', $this->request->getPost('product_id'));
                    })->findAll();

                // Jika BOM tidak ditemukan, rollback transaksi dan tampilkan pesan error
                if (empty($bomDetails)) {
                    $db->transRollback();
                    session()->setFlashdata('pesan', 'BOM tidak ditemukan untuk produk ini. Insert gagal!');
                    return redirect()->to(base_url('Produksi'))->withInput();
                }

                // Hitung kebutuhan material
                $materialReqModel = $this->ModelStruktur;
                foreach ($bomDetails as $bom) {
                    $grossRequirement = $bom['quantity_needed'] * $this->request->getPost('quality');

                    $dataMaterialReq = [
                        'production_planning_id' => $productionId,
                        'material_id' => $bom['material_id'],
                        'gross_requirement' => $grossRequirement,
                        'net_requirement' => 0, // Bisa dikurangi stok tersedia jika ada fitur stok
                        'status_material_requirement' => 'pending',
                    ];
                    if (!$materialReqModel->insert($dataMaterialReq)) {
                        throw new \Exception("Gagal menyimpan data material requirements.");
                    }
                }

                $db->transComplete(); // Selesaikan transaksi

                if ($db->transStatus() === false) {
                    throw new \Exception("Terjadi kesalahan saat menyimpan data.");
                }

                session()->setFlashdata('pesan', 'Produksi dan kebutuhan material berhasil ditambahkan!');
                return redirect()->to(base_url('Produksi'));
            } catch (\Exception $e) {
                $db->transRollback(); // Rollback jika terjadi error
                session()->setFlashdata('errors', [$e->getMessage()]);
                return redirect()->to(base_url('Produksi'))->withInput();
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Produksi'))->withInput();
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
                'product_id' => $this->request->getPost('product_id'),
                'order_number' => $this->request->getPost('order_number'),
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
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
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
