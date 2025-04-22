<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEksekusiStok extends Model
{
    protected $table = 'execution_stocks';
    protected $primaryKey = 'id_execution_stock';
    protected $allowedFields = [
        'production_execution_id',
        'material_id',
        'process_step_id',
        'name',
        'qty_produced',
        'final_qty',
        'status',
        'approved'
    ];

    public function AllData()
    {
        return $this->db->table('execution_stocks')
            // ->join('production_executions', 'production_executions.id_production_execution=execution_stocks.production_execution_id')
            // ->join('production_orders', 'production_orders.id_production_execution=production_executions.production_execution_id')
            // ->join('production_plannings', 'production_plannings.id=production_orders.production_planning_id')
            ->get()
            ->getResultArray();
    }

    public function getExecutionStocksByExecutionId($production_execution_id)
    {
        return $this->select('execution_stocks.*, materials.material_name, process_steps.step_name')
            ->join('materials', 'materials.id_material = execution_stocks.material_id', 'left')
            ->join('process_steps', 'process_steps.id_process_step=execution_stocks.process_step_id')
            ->where('execution_stocks.production_execution_id', $production_execution_id)
            ->findAll();
    }

    public function getSingleStockByExecutionId($executionId)
    {
        return $this->select('execution_stocks.*, materials.material_name, process_steps.step_name')
            ->join('materials', 'materials.id_material = execution_stocks.material_id', 'left')
            ->join('process_steps', 'process_steps.id_process_step = execution_stocks.process_step_id', 'left')
            ->where('execution_stocks.production_execution_id', $executionId)
            ->first();
    }

    public function getExecutionStocksByPlanningId($planningId)
    {
        return $this->select('execution_stocks.final_qty, production_orders.order_number')
            ->join('production_plannings', 'production_plannings.id=execution_stocks.production_planning_id')
            ->join('production_orders', 'production_orders.production_planning_id=production_plannings.id')
            ->where('execution_stocks.production_planning_id', $planningId)
            ->orderBy('execution_stocks.id_execution_stock', 'DESC')  // Mengurutkan berdasarkan ID terbaru
            // Atau jika ada kolom created_at, gunakan:
            // ->orderBy('execution_stocks.created_at', 'DESC')
            ->limit(1)  // Membatasi hanya mengambil 1 data yang paling terbaru
            ->get()
            ->getRowArray();
    }
}
