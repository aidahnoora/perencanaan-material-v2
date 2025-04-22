<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaterial;
use App\Models\ModelProduk;
use App\Models\ModelSupplier;
use App\Models\ModelUser;

class Admin extends BaseController
{
    protected $ModelProduk;
    protected $ModelMaterial;
    protected $ModelSupplier;
    protected $ModelUser;

    public function __construct()
    {
        $this->ModelProduk = new ModelProduk();
        $this->ModelMaterial = new ModelMaterial();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $data = [
            'judul' => 'Dashboard',
            'subjudul' => '',
            'menu' => 'dashboard',
            'submenu' => '',
            'page' => 'admin/v_home',
            'produk' => $this->ModelProduk->Counts(),
            'material' => $this->ModelMaterial->Counts(),
            'supplier' => $this->ModelSupplier->Counts(),
            'user' => $this->ModelUser->Counts(),
        ];
        return view('v_template', $data);
    }
}
