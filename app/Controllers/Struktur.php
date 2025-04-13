<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;
use App\Models\ModelProduksi;
use App\Models\ModelStruktur;

class Struktur extends BaseController
{
    public function __construct()
    {
        $this->ModelProduksi = new ModelProduksi();
        $this->ModelMaterial = new ModelMaterial();
        $this->ModelStruktur = new ModelStruktur();
    }

    public function index()
    {
        $produksi = $this->ModelProduksi->orderBy('id', 'DESC')->first();
        $data = [
            'judul' => 'Material Requirement',
            'subjudul' => '',
            'menu' => 'struktur',
            'submenu' => '',
            'page' => 'admin/v_struktur_produk',
            'productions' => $this->ModelProduksi->AllData(),
            'materials' => $this->ModelMaterial->AllData(),
            'strukturs' => $this->ModelStruktur->AllData(),
            'production_planning_id' => $produksi ? $produksi['id'] : null,
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'production_planning_id' => [
                'label' => 'Produksi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
            'material_id' => [
                'label' => 'Material',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
        ])) {
            $data = [
                'production_planning_id' => $this->request->getPost('production_planning_id'),
                'material_id' => $this->request->getPost('material_id'),
                'net_requirement' => $this->request->getPost('net_requirement'),
                'status_material_requirement' => $this->request->getPost('status_material_requirement'),
            ];
            $this->ModelStruktur->InsertData($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('Struktur'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Struktur'))->withInput('validation', \Config\Services::validation());
        }
    }

    public function UpdateData($id_material_requirement)
    {
        if ($this->validate([
            'production_planning_id' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
            'material_id' => [
                'label' => 'Material',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
        ])) {
            $data = [
                'id_material_requirement' => $id_material_requirement,
                'production_planning_id' => $this->request->getPost('production_planning_id'),
                'material_id' => $this->request->getPost('material_id'),
                'net_requirement' => $this->request->getPost('net_requirement'),
                'status_material_requirement' => $this->request->getPost('status_material_requirement'),
            ];
            $this->ModelStruktur->UpdateData($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
            return redirect()->to(base_url('Struktur'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Struktur'))->withInput('validation', \Config\Services::validation());
        }
    }

    public function DeleteData($id_material_requirement)
    {
        $data = [
            'id_material_requirement' => $id_material_requirement
        ];
        $this->ModelStruktur->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to('Struktur');
    }

    public function hitungMaterialRequirement()
    {
        // Ambil semua data produksi
        $produksiList = $this->ModelProduksi->findAll();

        if (!$produksiList) {
            session()->setFlashdata('errors', 'Tidak ada data produksi yang ditemukan!');
            return redirect()->to(base_url('Struktur'));
        }

        // Loop setiap produksi untuk menghitung material requirement
        foreach ($produksiList as $produksi) {
            // Ambil daftar material berdasarkan BOM untuk setiap produksi
            $materials = $this->ModelStruktur->where('production_planning_id', $produksi['id'])->findAll();

            foreach ($materials as $material) {
                // Cek apakah status material sudah fullfiled
                if ($material['status_material_requirement'] == 'fullfiled') {
                    continue; // Lewati perhitungan jika sudah fullfiled
                }

                // Stock On Hand → Stok material yang tersedia di gudang.
                // Ambil stok material dari gudang
                $stok = $this->ModelMaterial->find($material['material_id']);

                // Gross Requirement → Total kebutuhan material berdasarkan BOM dan jumlah produksi.
                // Gross Requirement = jumlah produksi * kebutuhan per unit
                $grossRequirement = $material['gross_requirement'];

                // Net Requirement → Kebutuhan material setelah dikurangi stok yang tersedia.
                // Net Requirement = Gross Requirement - Stock On Hand
                if ($material['status_material_requirement'] == 'partially') {
                    $netRequirement = max(0, $material['net_requirement'] - $stok['max_stock']);
                } else {
                    $netRequirement = max(0, $grossRequirement - $stok['max_stock']);
                }

                // Tentukan status material requirement
                if ($netRequirement == 0) {
                    $status = 'fullfiled';
                } elseif ($netRequirement > 0 && $stok['max_stock'] > 0) {
                    $status = 'partially';
                } else {
                    $status = 'pending';
                }

                // Update hanya jika belum fullfiled sebelumnya
                $this->ModelStruktur->update($material['id_material_requirement'], [
                    'net_requirement' => $netRequirement,
                    'status_material_requirement' => $status
                ]);

                // Kurangi stok material hanya jika belum fullfiled
                if ($stok['max_stock'] > $stok['min_stock']) {
                    $stokBaru = max(0, $stok['max_stock'] - $grossRequirement);
                    $this->ModelMaterial->update($material['material_id'], ['max_stock' => $stokBaru]);
                }
            }

            // Cek Status Material Requirement dalam Produksi ini
            $statusList = array_column($materials, 'status_material_requirement');

            // completed = jika semua material_requirement sudah fullfiled, inprogress = jika masih ada yang pending dan partially
            if (count(array_unique($statusList)) === 1 && $statusList[0] === 'fullfiled') {
                $statusProduksi = 'completed';
            } else {
                $statusProduksi = 'inprogress';
            }

            // Update Status Produksi
            $this->ModelProduksi->update($produksi['id'], ['status_production' => $statusProduksi]);
        }

        session()->setFlashdata('pesan', 'Perhitungan Material Requirement selesai! Hanya data yang belum fullfiled yang dihitung ulang.');
        return redirect()->to(base_url('Struktur'));
    }
}
