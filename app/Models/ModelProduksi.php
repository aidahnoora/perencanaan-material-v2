<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduksi extends Model
{
    protected $table = 'production_plannings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id',
        'order_number',
        'planned_date',
        'quality',
        'priority',
        'status_production',
        'notes'
    ];

    public function AllData()
    {
        return $this->db->table('production_plannings')
            ->join('products', 'products.id_product=production_plannings.product_id')
            ->orderBy('id', 'DESC')
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
