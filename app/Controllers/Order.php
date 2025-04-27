<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;
use App\Models\ModelOrderDetail;
use App\Models\ModelOrderProduksi;
use App\Models\ModelStruktur;

class Order extends BaseController
{
    protected $ModelOrderProduksi;
    protected $ModelOrderDetail;
    protected $ModelStruktur;
    protected $ModelMaterial;

    public function __construct()
    {
        $this->ModelOrderProduksi = new ModelOrderProduksi();
        $this->ModelOrderDetail = new ModelOrderDetail();
        $this->ModelStruktur = new ModelStruktur();
        $this->ModelMaterial = new ModelMaterial();
    }

    public function index()
    {
        $production_orders = $this->ModelOrderProduksi->AllData();

        foreach ($production_orders as &$order) {
            $order['production_order_details'] = $this->ModelOrderDetail->getOrderDetailsByOrderId($order['id_production_order']);
            $order['outputs'] = $this->ModelMaterial->where('source_process_step_id', $order['process_step_id'])->findAll();
            $order['getHasil'] = $this->ModelStruktur->where('material_id =', $order['material_hasil_id'])->findAll();
        }

        $data = [
            'judul' => 'Order',
            'subjudul' => '',
            'menu' => 'order',
            'submenu' => '',
            'page' => 'admin/v_order',
            'production_orders' => $production_orders,
        ];
        return view('v_template', $data);
    }

    public function InsertOrderTahap1()
    {
        $session = session();
        $materials = $this->request->getPost('materials');
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'production_planning_id' => $this->request->getPost('production_planning_id'),
                'bom_id' => $this->request->getPost('bom_id'),
                'product_id' => $this->request->getPost('productId'),
                'user_id' => $session->get('id_user'),
                'process_step_id' => 1,
                'order_number' => $this->request->getPost('order_number'),
                'planned_date_order' => $this->request->getPost('planned_date_order'),
                'target_qty' => $this->request->getPost('target_qty'),
                'status_order' => 'planned',
                'notes_order' => $this->request->getPost('notes_order'),
            ];

            $this->ModelOrderProduksi->insert($data);
            $orderId = $this->ModelOrderProduksi->insertID();

            $db->table('production_plannings')
                ->where('id', $data['production_planning_id'])
                ->update([
                    'status_production' => 'inprogress',
                    'process_step_log' => '1',
                ]);

            foreach ($materials as $material) {
                $this->ModelOrderDetail->insert([
                    'production_order_id' => $orderId,
                    'material_id' => $material['material_id'],
                    'gross_requirement' => $material['gross_requirement'],
                    'qty_buffer' => $material['qty_buffer']
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Transaksi gagal");
            }

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        } catch (\Throwable $e) {
            $db->transRollback();
            session()->setFlashdata('pesan', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->to('Produksi');
    }

    public function InsertOrderTahap2()
    {
        $session = session();
        $materials = $this->request->getPost('materials');
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'production_planning_id' => $this->request->getPost('production_planning_id'),
                'bom_id' => $this->request->getPost('bom_id_2'),
                'product_id' => $this->request->getPost('productId'),
                'user_id' => $session->get('id_user'),
                'process_step_id' => 2,
                'order_number' => $this->request->getPost('order_number'),
                'planned_date_order' => $this->request->getPost('planned_date_order'),
                'target_qty' => $this->request->getPost('target_qty'),
                'status_order' => 'planned',
                'notes_order' => $this->request->getPost('notes_order'),
            ];

            // Simpan order produksi utama
            $this->ModelOrderProduksi->insert($data);
            $orderId = $this->ModelOrderProduksi->insertID();

            // Update status produksi
            $db->table('production_plannings')
                ->where('id', $data['production_planning_id'])
                ->update([
                    'status_production' => 'inprogress',
                    'process_step_log' => '2',
                    'order_log' => 'inprogress'
                ]);

            // Simpan detail material requirements
            foreach ($materials as $material) {
                $this->ModelOrderDetail->insert([
                    'production_order_id' => $orderId,
                    'material_id' => $material['material_id'],
                    'gross_requirement' => $material['gross_requirement'],
                    'qty_buffer' => $material['gross_requirement'] + ($material['gross_requirement'] * 20 / 100),
                ]);

                $this->ModelStruktur->update($material['id_material_requirement'], [
                    'qty_buffer' => $material['gross_requirement'] + ($material['gross_requirement'] * 20 / 100),
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                $lastQuery = $db->getLastQuery();
                log_message('error', 'Transaksi gagal. Query terakhir: ' . $lastQuery);
                throw new \Exception("Transaksi gagal. Cek log untuk detail.");
            }

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        } catch (\Throwable $e) {
            $db->transRollback();
            session()->setFlashdata('pesan', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->to('Produksi');
    }

    public function InsertOrderTahap3()
    {
        $session = session();
        $materials = $this->request->getPost('materials');
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'production_planning_id' => $this->request->getPost('production_planning_id'),
                'bom_id' => $this->request->getPost('bom_id_3'),
                'product_id' => $this->request->getPost('productId'),
                'user_id' => $session->get('id_user'),
                'process_step_id' => 3,
                'order_number' => $this->request->getPost('order_number'),
                'planned_date_order' => $this->request->getPost('planned_date_order'),
                'target_qty' => $this->request->getPost('target_qty'),
                'status_order' => 'planned',
                'notes_order' => $this->request->getPost('notes_order'),
            ];

            // Simpan order produksi utama
            $this->ModelOrderProduksi->insert($data);
            $orderId = $this->ModelOrderProduksi->insertID();

            // Update status produksi
            $db->table('production_plannings')
                ->where('id', $data['production_planning_id'])
                ->update([
                    'status_production' => 'inprogress',
                    'process_step_log' => '3',
                    'order_log' => 'inprogress'
                ]);

            // Simpan detail material requirements
            foreach ($materials as $material) {
                $this->ModelOrderDetail->insert([
                    'production_order_id' => $orderId,
                    'material_id' => $material['material_id'],
                    'gross_requirement' => $material['gross_requirement'],
                    'qty_buffer' => $material['gross_requirement'] + ($material['gross_requirement'] * 20 / 100),
                ]);

                $this->ModelStruktur->update($material['id_material_requirement'], [
                    'qty_buffer' => $material['gross_requirement'] + ($material['gross_requirement'] * 20 / 100),
                ]);
            }

            // dd($materials);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Transaksi gagal");
            }

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        } catch (\Throwable $e) {
            $db->transRollback();
            session()->setFlashdata('pesan', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->to('Produksi');
    }

    public function InsertOrderTahap4()
    {
        $session = session();
        $materials = $this->request->getPost('materials');
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'production_planning_id' => $this->request->getPost('production_planning_id'),
                'bom_id' => $this->request->getPost('bom_id_4'),
                'product_id' => $this->request->getPost('productId'),
                'user_id' => $session->get('id_user'),
                'process_step_id' => 4,
                'order_number' => $this->request->getPost('order_number'),
                'planned_date_order' => $this->request->getPost('planned_date_order'),
                'target_qty' => $this->request->getPost('target_qty'),
                'status_order' => 'planned',
                'notes_order' => $this->request->getPost('notes_order'),
            ];

            // Simpan order produksi utama
            $this->ModelOrderProduksi->insert($data);
            $orderId = $this->ModelOrderProduksi->insertID();

            // Update status produksi
            $db->table('production_plannings')
                ->where('id', $data['production_planning_id'])
                ->update([
                    'status_production' => 'inprogress',
                    'process_step_log' => '4',
                    'order_log' => 'inprogress'
                ]);

            // Simpan detail material requirements
            foreach ($materials as $material) {
                $this->ModelOrderDetail->insert([
                    'production_order_id' => $orderId,
                    'material_id' => $material['material_id'],
                    'gross_requirement' => $material['gross_requirement'],
                    'qty_buffer' => $material['gross_requirement'] + ($material['gross_requirement'] * 20 / 100),
                ]);

                $this->ModelStruktur->update($material['id_material_requirement'], [
                    'qty_buffer' => $material['gross_requirement'] + ($material['gross_requirement'] * 20 / 100),
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Transaksi gagal");
            }

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        } catch (\Throwable $e) {
            $db->transRollback();
            session()->setFlashdata('pesan', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->to('Produksi');
    }
}
