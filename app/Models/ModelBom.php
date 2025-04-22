<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBom extends Model
{
    protected $table = 'boms';
    protected $primaryKey = 'id_bom';
    protected $allowedFields = [
        'product_id',
        'process_step_id',
        'bom_code',
        'bom_version',
        'effective_date',
        'approved_by',
        'notes'
    ];

    public function AllData()
    {
        $boms = $this->select('boms.*, products.product_name')
            ->join('products', 'products.id_product = boms.product_id')
            ->join('process_steps', 'process_steps.id_process_step = boms.process_step_id')
            ->orderBy('boms.id_bom', 'DESC')
            ->findAll();

        $bomDetailModel = new ModelBomDetail(); // Pastikan model ini ada
        foreach ($boms as &$bom) {
            $bom['bom_details'] = $bomDetailModel->where('bom_id', $bom['id_bom'])->findAll();
        }

        return $boms;
    }

    public function InsertData($data)
    {
        $this->insert($data);
        return $this->insertID(); // Mengembalikan ID terakhir yang dimasukkan
    }

    public function UpdateData($data)
    {
        return $this->update($data['id_bom'], $data);
    }

    public function DeleteData($id)
    {
        return $this->delete($id);
    }

    public function Counts()
    {
        return $this->db->table('boms')->countAllResults();
    }

    public function getByStep($step_id)
    {
        return $this->select('boms.*, products.product_name, process_steps.step_name')
            ->join('products', 'products.id_product = boms.product_id')
            ->join('process_steps', 'process_steps.id_process_step = boms.process_step_id')
            ->where('boms.process_step_id', $step_id)
            ->orderBy('boms.id_bom', 'DESC')
            ->findAll();
    }
}
