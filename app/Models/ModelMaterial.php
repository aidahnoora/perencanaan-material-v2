<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMaterial extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id_material';
    protected $allowedFields = [
        'material_code',
        'material_name',
        'material_spec',
        'material_type',
        'grade',
        'standard_cost',
        'bom',
        'standard_cost',
        'max_stock',
        'type',
        'source_process_step_id'
    ];

    public function AllData()
    {
        return $this->db->table('materials')
            ->where('type !=', 'none')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('materials')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('materials')
            ->where('id_material', $data['id_material'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('materials')
            ->where('id_material', $data['id_material'])
            ->delete($data);
    }

    public function Counts()
    {
        return $this->db->table('materials')->where('type !=', 'none')->countAllResults();
    }
}
