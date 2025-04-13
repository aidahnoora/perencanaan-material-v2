<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStruktur extends Model
{
    protected $table = 'material_requirements';
    protected $primaryKey = 'id_material_requirement';
    protected $allowedFields = ['production_planning_id', 'material_id', 'gross_requirement', 'net_requirement', 'status_material_requirement'];
    
    public function AllData()
    {
        return $this->db->table('material_requirements')
            ->join('production_plannings', 'production_plannings.id=material_requirements.production_planning_id')
            ->join('materials', 'materials.id_material=material_requirements.material_id')
            ->join('products', 'products.id_product=production_plannings.product_id')
            ->orderBy('id_material_requirement', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('material_requirements')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('material_requirements')
            ->where('id_material_requirement', $data['id_material_requirement'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('material_requirements')
            ->where('id_material_requirement', $data['id_material_requirement'])
            ->delete($data);
    }

    public function getAssetById($id_material_requirement)
    {
        return $this->db->table('material_requirements')
            ->join('production_plannings', 'production_plannings.id=material_requirements.production_planning_id')
            ->join('materials', 'materials.id_material=material_requirements.material_id')
            ->where('id_material_requirement', $id_material_requirement)
            ->get()
            ->getRowArray();
    }
}
