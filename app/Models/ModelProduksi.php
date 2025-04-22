<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduksi extends Model
{
    protected $table = 'production_plannings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id',
        'planned_date',
        'quality',
        'priority',
        'status_production',
        'notes',
    ];

    public function AllData()
    {
        return $this->db->table('production_plannings')
            ->select('production_plannings.*, products.*')
            // (SELECT process_steps.step_name 
            //  FROM boms 
            //  JOIN process_steps ON process_steps.id_process_step = boms.process_step_id 
            //  WHERE boms.product_id = production_plannings.product_id 
            //  LIMIT 1) AS step_name')
            ->join('products', 'products.id_product = production_plannings.product_id')
            // ->join('production_orders', 'production_orders.production_planning_id=production_plannings.id')
            ->orderBy('production_plannings.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('production_plannings')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('production_plannings')
            ->where('id', $data['id'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('production_plannings')
            ->where('id', $data['id'])
            ->delete($data);
    }

    public function getAssetById($id)
    {
        return $this->db->table('production_plannings')
            ->join('products', 'products.id=production_plannings.product_id')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }
}
