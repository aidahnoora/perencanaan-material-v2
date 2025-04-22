<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOrderProduksi extends Model
{
    protected $table = 'production_orders'; 
    protected $primaryKey = 'id_production_order';
    protected $allowedFields = [
        'production_planning_id', 
        'bom_id', 
        'user_id',
        'process_step_id',
        'order_number',
        'product_id',
        'planned_date_order', 
        'target_qty', 
        'status_order', 
        'notes_order',
    ];

    public function AllData()
    {
        return $this->db->table('production_orders')
            ->join('products', 'products.id_product = production_orders.product_id')
            ->join('process_steps', 'process_steps.id_process_step=production_orders.process_step_id')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('production_orders')->insert($data);
    }
}