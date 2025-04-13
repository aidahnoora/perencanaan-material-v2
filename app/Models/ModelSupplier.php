<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSupplier extends Model
{
    public function AllData()
    {
        return $this->db->table('suppliers')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('suppliers')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('suppliers')
            ->where('id_supplier', $data['id_supplier'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('suppliers')
            ->where('id_supplier', $data['id_supplier'])
            ->delete($data);
    }

    public function Counts()
    {
        return $this->db->table('suppliers')->countAllResults();
    }
}