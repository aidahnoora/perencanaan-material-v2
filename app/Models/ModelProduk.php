<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduk extends Model
{
    public function AllData()
    {
        return $this->db->table('products')
            ->get()
            ->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('products')->insert($data);
    }

    public function UpdateData($data)
    {
        $this->db->table('products')
            ->where('id_product', $data['id_product'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('products')
            ->where('id_product', $data['id_product'])
            ->delete($data);
    }

    public function Counts()
    {
        return $this->db->table('products')->countAllResults();
    }
}
