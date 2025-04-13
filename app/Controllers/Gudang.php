<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;
use App\Models\ModelProduk;
use App\Models\ModelSupplier;
use App\Models\ModelBom;

class Gudang extends BaseController
{
    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelMaterial = new ModelMaterial();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelBom = new ModelBom();
    }

    public function index()
    {
        $data = [
            'judul' => 'Gudang',
            'subjudul' => '',
            'menu' => 'gudang',
            'submenu' => '',
            'page' => 'gudang/v_home',
            'produk' => $this->ModelProduk->Counts(),
            'material' => $this->ModelMaterial->Counts(),
            'supplier' => $this->ModelSupplier->Counts(),
            'bom' => $this->ModelBom->Counts(),
        ];
        return view('v_template', $data);
    }
}
