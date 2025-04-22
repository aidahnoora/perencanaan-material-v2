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
}
