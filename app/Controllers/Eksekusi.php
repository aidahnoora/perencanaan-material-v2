<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelEksekusiProduksi;
use App\Models\ModelEksekusiStok;

class Eksekusi extends BaseController
{
    protected $ModelEksekusiProduksi;
    protected $ModelEksekusiStok;

    public function __construct()
    {
        $this->ModelEksekusiProduksi = new ModelEksekusiProduksi();
        $this->ModelEksekusiStok = new ModelEksekusiStok();
    }

    public function index()
    {
        $production_executions = $this->ModelEksekusiProduksi->AllData();

        foreach ($production_executions as &$execution) {
            $execution['execution_stock'] = $this->ModelEksekusiStok->getSingleStockByExecutionId($execution['id_production_execution']);
            $execution['execution_stocks'] = $this->ModelEksekusiStok->getExecutionStocksByExecutionId($execution['id_production_execution']);

            // dd($execution['execution_stock']);
        }

        $data = [
            'judul' => 'Eksekusi',
            'subjudul' => '',
            'menu' => 'eksekusi',
            'submenu' => '',
            'page' => 'admin/v_eksekusi',
            'production_executions' => $production_executions,
        ];
        return view('v_template', $data);
    }

    public function InsertData()
    {
        $session = session();
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $data = [
                'production_order_id' => $this->request->getPost('production_order_id'),
                'user_id' => $session->get('id_user'),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'status_execution' => $this->request->getPost('status_execution'),
                'notes_execution' => $this->request->getPost('notes_execution'),
                'production_planning_id' => $this->request->getPost('production_planning_id'),
            ];

            $execution_id = $this->ModelEksekusiProduksi->InsertData($data);

            $material_ids = $this->request->getPost('material_id[]');
            $qty_used = $this->request->getPost('qty_used[]');
            $source_type = $this->request->getPost('source_type[]');

            // dd([
            //     'material_ids' => $material_ids,
            //     'qty_used' => $qty_used,
            //     'source_type' => $source_type
            // ]);            

            foreach ($material_ids as $index => $material_id) {
                $material_data = [
                    'production_execution_id' => $execution_id,
                    'material_id' => $material_id,
                    'qty_used' => $qty_used[$index],
                    'source_type' => $source_type[$index],
                ];

                // echo "<pre>";
                // print_r($material_data);
                // echo "</pre>";
                // exit;

                $this->ModelEksekusiProduksi->InsertMaterialData($material_data);

                $db->table('materials')
                    ->where('id_material', $material_id)
                    ->set('max_stock', 'max_stock - ' . (int) $qty_used[$index], false)
                    ->update();
            }

            $output_ids = $this->request->getPost('output_id'); // array
            $qty_produced = $this->request->getPost('qty_produced'); // array

            if (!empty($output_ids)) {
                foreach ($output_ids as $index => $id) {
                    $material = $db->table('materials')->where('id_material', $id)->get()->getRow();

                    $output_data = [
                        'production_execution_id' => $execution_id,
                        'process_step_id' => $this->request->getPost('process_step_id'),
                        'material_id' => $id,
                        'name' => $material->material_name ?? '-',
                        'qty_produced' => $qty_produced[$index] ?? 0,
                        'status' => 'pending',
                        'production_planning_id' => $this->request->getPost('production_planning_id'),
                    ];

                    $this->ModelEksekusiProduksi->InsertOutputData($output_data);
                }
            }

            $db->table('production_orders')
                ->where('id_production_order', $data['production_order_id'])
                ->update([
                    'status_order' => 'inprogress'
                ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Terjadi kesalahan saat menyimpan data.");
            }

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('Order'))->withInput();
        } catch (\Exception $e) {
            $db->transRollback();

            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->to(base_url('Order'))->withInput();
        }
    }

    public function UpdateData($id_production_execution)
    {
        $data = [
            'id_production_execution' => $id_production_execution,
            'status_execution' => $this->request->getPost('status_execution'),
        ];
        $this->ModelEksekusiProduksi->UpdateData($data);

        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to('Eksekusi');
    }

    public function KirimApproval()
    {
        $session = session();
        $db = \Config\Database::connect();
        $db->transStart();
    
        $execution_stock_ids = $this->request->getPost('execution_stock_id');
        $approved_qtys = $this->request->getPost('approved_qty');
    
        foreach ($execution_stock_ids as $index => $execution_stock_id) {
            $data = [
                'execution_stock_id' => $execution_stock_id,
                'user_id' => $session->get('id_user'),
                'role' => 'spv',
                'approved_qty' => $approved_qtys[$index] ?? 0,
                'rejected_qty' => 0,
                'notes_approval' => 'Pengajuan Realisasi',
                'approve_at' => date('Y-m-d H:i:s'),
            ];
    
            $this->ModelEksekusiProduksi->InsertApproval($data);
    
            // Update status approved di execution_stocks
            $db->table('execution_stocks')
                ->where('id_execution_stock', $execution_stock_id)
                ->update(['approved' => true]);
    
            // Ambil production_execution_id
            $row = $db->table('execution_stocks')
                ->select('production_execution_id')
                ->where('id_execution_stock', $execution_stock_id)
                ->get()
                ->getRow();
    
            if ($row) {
                $db->table('production_executions')
                    ->where('id_production_execution', $row->production_execution_id)
                    ->update(['status_execution' => 'awaiting_approval']);
            }
        }
    
        $db->transComplete();
    
        if ($db->transStatus() === false) {
            session()->setFlashdata('errors', ['Terjadi kesalahan saat menyimpan data.']);
        } else {
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        }
    
        return redirect()->to(base_url('Eksekusi'));
    }
    
}
