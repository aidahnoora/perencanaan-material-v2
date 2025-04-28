<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;

class Laporan extends BaseController
{
    protected $ModelMaterial;

    public function __construct()
    {
        $this->ModelMaterial = new ModelMaterial();
    }

    public function index()
    {
        $data = [
            'judul' => 'Laporan',
            'subjudul' => '',
            'menu' => 'laporan',
            'submenu' => '',
            'page' => 'admin/v_laporan_stok',
            'materials' => $this->ModelMaterial->AllData(),
        ];

        return view('v_template', $data);
    }

    public function print()
    {
        $data['materials'] = $this->ModelMaterial->findAll();
        return view('admin/print', $data);
    }

    public function laporanRealisasi()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT
                production_plannings.id, 
                products.product_name,
                execution_stocks.process_step_id,
                production_orders.order_number, 
                production_orders.planned_date_order, 
                execution_approvals.approved_qty, 
                execution_approvals.rejected_qty, 
                execution_stocks.final_qty, 
                execution_stocks.`status`,
                execution_stocks.name
            FROM execution_approvals
            JOIN execution_stocks ON execution_stocks.id_execution_stock = execution_approvals.execution_stock_id
            JOIN production_executions ON production_executions.id_production_execution = execution_stocks.production_execution_id
            JOIN production_orders ON production_orders.id_production_order = production_executions.production_order_id
            JOIN production_plannings ON production_plannings.id = production_orders.production_planning_id
            JOIN products ON products.id_product = production_plannings.product_id
            WHERE execution_approvals.role='qc';
        ");

        $laporan = $query->getResult();

        $data = [
            'judul' => 'Laporan',
            'subjudul' => '',
            'menu' => 'laporanRealisasi',
            'submenu' => '',
            'page' => 'admin/v_laporan_realisasi',
            'laporan' => $laporan
        ];

        return view('v_template', $data);
    }

    public function printRealisasi()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT
                production_plannings.id, 
                products.product_name, 
                execution_stocks.process_step_id,
                production_orders.order_number, 
                production_orders.planned_date_order, 
                execution_approvals.approved_qty, 
                execution_approvals.rejected_qty, 
                execution_stocks.final_qty, 
                execution_stocks.`status`
            FROM execution_approvals
            JOIN execution_stocks ON execution_stocks.id_execution_stock = execution_approvals.execution_stock_id
            JOIN production_executions ON production_executions.id_production_execution = execution_stocks.production_execution_id
            JOIN production_orders ON production_orders.id_production_order = production_executions.production_order_id
            JOIN production_plannings ON production_plannings.id = production_orders.production_planning_id
            JOIN products ON products.id_product = production_plannings.product_id
            WHERE execution_approvals.role='qc';
        ");

        $data['laporan'] = $query->getResult();
        return view('admin/printRealisasi', $data);
    }
}
