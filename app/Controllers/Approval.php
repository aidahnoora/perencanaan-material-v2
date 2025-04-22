<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelEksekusiApproval;

class Approval extends BaseController
{
    protected $ModelEksekusiApproval;

    public function __construct()
    {
        $this->ModelEksekusiApproval = new ModelEksekusiApproval();
    }

    public function index()
    {
        $execution_stocks = $this->ModelEksekusiApproval->AllData();

        foreach ($execution_stocks as &$execution) {
            $execution['execution_approvals'] = $this->ModelEksekusiApproval->getApprovalByExecutionStock($execution['id_execution_stock']);
        }

        $data = [
            'judul' => 'Approval',
            'subjudul' => '',
            'menu' => 'approval',
            'submenu' => '',
            'page' => 'admin/v_approval',
            'execution_stocks' => $execution_stocks,
        ];
        return view('v_template', $data);
    }

    public function InsertData()
    {
        $session = session();
        $db = \Config\Database::connect();

        $data = [
            'execution_stock_id' => $this->request->getPost('execution_stock_id'),
            'user_id' => $session->get('id_user'),
            'role' => 'qc',
            'approved_qty' => $this->request->getPost('approved_qty'),
            'rejected_qty' => $this->request->getPost('rejected_qty'),
            'notes_approval' => $this->request->getPost('notes_approval'),
            'approve_at' => date('Y-m-d H:i:s'),
        ];

        $this->ModelEksekusiApproval->InsertData($data);

        // Update execution_stocks (setelah approval)
        $db->table('execution_stocks')
            ->where('id_execution_stock', $data['execution_stock_id'])
            ->update([
                'status' => 'approved',
                'final_qty' => $data['approved_qty']
            ]);

        $row = $db->table('execution_stocks')
            ->select('production_execution_id, material_id')
            ->where('id_execution_stock', $data['execution_stock_id'])
            ->get()
            ->getRow();

        if ($row) {
            $db->table('production_executions')
                ->where('id_production_execution', $row->production_execution_id)
                ->update([
                    'status_execution' => 'approved'
                ]);

            $execution = $db->table('production_executions')
                ->select('production_order_id')
                ->where('id_production_execution', $row->production_execution_id)
                ->get()
                ->getRow();

            if ($execution) {
                $order = $db->table('production_orders')
                    ->where('id_production_order', $execution->production_order_id)
                    ->get()
                    ->getRow();

                if ($order) {
                    // Update status_order ke 'completed'
                    $db->table('production_orders')
                        ->where('id_production_order', $execution->production_order_id)
                        ->update([
                            'status_order' => 'completed'
                        ]);

                    // Update production_plannings -> order_log
                    $db->table('production_plannings')
                        ->where('id', $order->production_planning_id)
                        ->update([
                            'order_log' => 'completed',
                            // 'status_production' => 'completed',
                        ]);
                }
            }

            $db->table('materials')
                ->where('id_material', $row->material_id)
                ->set('max_stock', 'max_stock + ' . (int)$data['approved_qty'], false)
                ->update();

            $mate = $db->table('execution_materials')
                ->select('production_execution_id, material_id, qty_used')
                ->where('production_execution_id', $row->production_execution_id)
                ->get()
                ->getRowArray();

            if ($mate) {
                $db->table('materials')
                    ->where('id_material', $mate['material_id'])
                    ->set('max_stock', 'max_stock - ' . (int)$mate['qty_used'], false)
                    ->update();
            }
        }

        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
        return redirect()->to(base_url('Approval'));
    }
}
