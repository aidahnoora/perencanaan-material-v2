<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOrderDetail extends Model
{
    protected $table = 'production_order_details';
    protected $primaryKey = 'id_detail_production_order';
    protected $allowedFields = [
        'production_order_id', 'material_id', 'qty_buffer', 'gross_requirement'
    ];

    public function getOrderDetailsByOrderId($production_order_id)
    {
        return $this->select('production_order_details.*, materials.material_name')
            ->join('materials', 'materials.id_material = production_order_details.material_id', 'left')
            // ->join('execution_stocks', 'execution_stocks.material_id=materials.id_material', 'left')
            ->where('production_order_details.production_order_id', $production_order_id)
            ->findAll();
    }
}
