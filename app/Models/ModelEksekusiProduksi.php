<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEksekusiProduksi extends Model
{
    protected $table = 'production_executions';
    protected $primaryKey = 'id_production_execution';
    protected $allowedFields = [
        'production_order_id',
        'user_id',
        'start_time',
        'end_time',
        'status_execution',
        'notes_execution',
        'production_planning_id'
    ];

    public function AllData()
    {
        return $this->db->table('production_executions')
            ->join('production_orders', 'production_orders.id_production_order=production_executions.production_order_id')
            ->join('process_steps', 'process_steps.id_process_step=production_orders.process_step_id')
            ->join('products', 'products.id_product = production_orders.product_id')
            ->join('tbl_user', 'tbl_user.id_user=production_executions.user_id')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('production_executions')->insert($data);
        return $this->db->insertID();
    }

    public function UpdateData($data)
    {
        $this->db->table('production_executions')
            ->where('id_production_execution', $data['id_production_execution'])
            ->update($data);
    }

    public function InsertMaterialData($data)
    {
        $this->db->table('execution_materials')->insert($data);
    }

    public function InsertOutputData($data)
    {
        $this->db->table('execution_stocks')->insert($data);
    }

    public function InsertApproval($data)
    {
        $this->db->table('execution_approvals')->insert($data);
    }
}
