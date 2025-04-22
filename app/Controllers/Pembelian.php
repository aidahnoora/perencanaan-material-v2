<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;
use App\Models\ModelPembelian;
use App\Models\ModelSupplier;

class Pembelian extends BaseController
{
    public function __construct()
    {
        $this->ModelMaterial = new ModelMaterial();
        $this->ModelPembelian = new ModelPembelian();
        $this->ModelSupplier = new ModelSupplier();

    }

    public function index()
    {
        $data = [
            'judul' => 'Pembelian',
            'subjudul' => '',
            'menu' => 'pembelian',
            'submenu' => '',
            'page' => 'admin/v_pembelian',
            'materials' => $this->ModelMaterial->AllData(),
            'suppliers' => $this->ModelSupplier->AllData(),
            'inventories' => $this->ModelPembelian->AllData(),
        ];

        return view('v_template', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'material_id' => [
                'label' => 'Material',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
            'current_stock' => [
                'label' => 'Jumlah Stok',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} Harus Diinputkan!',
                    'integer' => '{field} Harus berupa angka!'
                ]
            ]
        ])) {
            $material_id = $this->request->getPost('material_id');
            $current_stock = $this->request->getPost('current_stock');

            // Simpan data pembelian
            $data = [
                'material_id' => $material_id,
                'supplier_id' => $this->request->getPost('supplier_id'),
                'current_stock' => $current_stock,
                'allocated_qty' => $current_stock,
                'warehouse_location' => $this->request->getPost('warehouse_location'),
                'batch_number' => $this->request->getPost('batch_number'),
                'last_update' => $this->request->getPost('last_update'),
            ];
            $this->ModelPembelian->InsertData($data);

            // Tambahkan stok ke tabel material
            $material = $this->ModelMaterial->find($material_id);
            if ($material) {
                $newStock = $material['max_stock'] + $current_stock;
                $this->ModelMaterial->update($material_id, ['max_stock' => $newStock]);
            }

            session()->setFlashdata('pesan', 'Data Pembelian Berhasil Ditambahkan & Stok Material Diperbarui!');
            return redirect()->to(base_url('Pembelian'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Pembelian'))->withInput();
        }
    }

    public function UpdateData($id_inventory)
    {
        if ($this->validate([
            'material_id' => [
                'label' => 'Material',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Diinputkan!',
                ]
            ],
            'current_stock' => [
                'label' => 'Jumlah Stok',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} Harus Diinputkan!',
                    'integer' => '{field} Harus berupa angka!'
                ]
            ]
        ])) {
            $material_id = $this->request->getPost('material_id');
            $current_stock_baru = $this->request->getPost('current_stock');

            // Ambil data pembelian lama
            $pembelianLama = $this->ModelPembelian->find($id_inventory);

            if ($pembelianLama) {
                $current_stock_lama = $pembelianLama['current_stock'];
                $material = $this->ModelMaterial->find($material_id);

                if ($material) {
                    // Perhitungan selisih stok
                    $selisihStock = $current_stock_baru - $current_stock_lama;
                    $newStock = max(0, $material['max_stock'] + $selisihStock);

                    // Update stok pada tabel material
                    $this->ModelMaterial->update($material_id, ['max_stock' => $newStock]);
                }
            }

            // Update data pembelian
            $data = [
                'id_inventory' => $id_inventory,
                'material_id' => $material_id,
                'supplier_id' => $this->request->getPost('supplier_id'),
                'current_stock' => $current_stock_baru,
                'allocated_qty' => $current_stock,
                'warehouse_location' => $this->request->getPost('warehouse_location'),
                'batch_number' => $this->request->getPost('batch_number'),
                'last_update' => $this->request->getPost('last_update'),
            ];
            $this->ModelPembelian->UpdateData($data);

            session()->setFlashdata('pesan', 'Data Pembelian Berhasil Diupdate & Stok Material Disesuaikan!');
            return redirect()->to(base_url('Pembelian'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Pembelian'))->withInput();
        }
    }

    public function DeleteData($id_inventory)
    {
        $pembelian = $this->ModelPembelian->find($id_inventory);

        if ($pembelian) {
            $material_id = $pembelian['material_id'];
            $current_stock = $pembelian['current_stock'];

            // Hapus data pembelian
            $this->ModelPembelian->DeleteData(['id_inventory' => $id_inventory]);

            // Kurangi stok material jika ada
            $material = $this->ModelMaterial->find($material_id);
            if ($material) {
                $newStock = max(0, $material['max_stock'] - $current_stock);
                $this->ModelMaterial->update($material_id, ['max_stock' => $newStock]);
            }
        }

        session()->setFlashdata('pesan', 'Data Pembelian Berhasil Dihapus & Stok Material Dikurangi!');
        return redirect()->to(base_url('Pembelian'));
    }
}
