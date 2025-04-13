<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBomDetail extends Model
{
    protected $table = 'bom_details';
    protected $primaryKey = 'id_bom_detail';
    protected $allowedFields = ['bom_id', 'material_id', 'quantity_needed', 'level', 'proces_notes'];

    public function getBomDetailsByBomId($bom_id)
    {
        return $this->select('bom_details.*, materials.material_name')
                    ->join('materials', 'materials.id_material = bom_details.material_id', 'left')
                    ->where('bom_details.bom_id', $bom_id)
                    ->findAll();
    }

    // public function InsertBatch($data)
    // {
    //     return $this->insertBatch($data);
    // }

    public function DeleteByBomId($bom_id)
    {
        return $this->where('bom_id', $bom_id)->delete();
    }
}
