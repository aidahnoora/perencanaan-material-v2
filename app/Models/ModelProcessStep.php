<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProcessStep extends Model
{
    public function AllData()
    {
        return $this->db->table('process_steps')
            ->get()
            ->getResultArray();
    }

    public function UpdateData($data)
    {
        $this->db->table('process_steps')
            ->where('id_process_step', $data['id_process_step'])
            ->update($data);
    }
}