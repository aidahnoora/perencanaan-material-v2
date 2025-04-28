<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEksekusiApproval extends Model
{
    protected $table = 'execution_approvals';
    protected $primaryKey = 'id_execution_approval';
    protected $allowedFields = [
        'execution_stock_id',
        'user_id',
        'role',
        'approved_qty',
        'rejected_qty',
        'notes_approval',
        'approve_at'
    ];

    // ambil dari execution_stocks untuk ditampilkan di approval, nanti
    // ambil dari execution_approvals untuk ditampilkan sbg riwayat
    public function AllData()
    {
        return $this->db->table('execution_stocks')
            ->select('execution_stocks.*, process_steps.step_name, process_steps.step_order, production_orders.order_number,  
                production_orders.planned_date_order, products.product_name')
            ->join('process_steps', 'process_steps.id_process_step = execution_stocks.process_step_id', 'left')
            ->join('production_executions', 'production_executions.id_production_execution = execution_stocks.production_execution_id', 'left')
            ->join('production_orders', 'production_orders.id_production_order = production_executions.production_order_id', 'left')
            ->join('products', 'products.id_product = production_orders.product_id', 'left')
            ->where('execution_stocks.approved', true)
            ->orderBy('id_execution_stock', 'desc')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('execution_approvals')->insert($data);
    }

    public function getApprovalByExecutionStock($id_execution_stock)
    {
        return $this->db->table('execution_approvals')
            ->select('execution_approvals.*, tbl_user.nama_user as approved_by')
            ->join('tbl_user', 'tbl_user.id_user = execution_approvals.user_id', 'left')
            ->where('execution_approvals.execution_stock_id', $id_execution_stock)
            ->orderBy('approve_at', 'asc')
            ->get()
            ->getResultArray();
    }
}
