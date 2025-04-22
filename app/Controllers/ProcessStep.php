<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProcessStep;

class ProcessStep extends BaseController
{
    public function __construct()
    {
        $this->ModelProcessStep = new ModelProcessStep();
    }

    public function index()
    {
        $data = [
            'judul' => 'ProcessStep',
            'subjudul' => '',
            'menu' => 'process_step',
            'submenu' => '',
            'page' => 'admin/v_process_step',
            'process_steps' => $this->ModelProcessStep->AllData(),
        ];

        return view('v_template', $data);
    }

    public function UpdateData($id_process_step)
    {
        $data = [
            'id_process_step' => $id_process_step,
            'step_name' => $this->request->getPost('step_name'),
            'step_order' => $this->request->getPost('step_order'),
            'description' => $this->request->getPost('description'),
        ];

        $this->ModelProcessStep->UpdateData($data);

        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!');
        return redirect()->to('ProcessStep');
    }
}
