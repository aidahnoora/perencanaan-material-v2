<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembelian extends Model
{
    protected $table = 'inventories';
    protected $primaryKey = 'id_inventory';
    protected $allowedFields = [
        'material_id',
        'supplier_id',
        'current_stock',
        'allocated_qty',
        'warehouse_location',
        'batch_number',
        'last_update'
    ];

    public function AllData()
    {
        return $this->db->table('inventories')
            ->join('materials', 'materials.id_material=inventories.material_id')
            ->join('suppliers', 'suppliers.id_supplier=inventories.supplier_id')
            ->orderBy('id_inventory', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('inventories')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('inventories')
            ->where('id_inventory', $data['id_inventory'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('inventories')
            ->where('id_inventory', $data['id_inventory'])
            ->delete($data);
    }

    public function getAssetById($id_inventory)
    {
        return $this->db->table('inventories')
            ->join('materials', 'materials.id_material=inventories.material_id')
            ->where('id_inventory', $id_inventory)
            ->get()
            ->getRowArray();
    }
}
