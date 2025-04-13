<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>

            <div class="card-tools">
                <!-- <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add-data"><i class="fas fa-plus"></i> Add Data
                </button> -->
                <a href="<?= base_url('Struktur/hitungMaterialRequirement'); ?>" class="btn btn-tool">
                    <i class="fas fa-calculator"></i> &nbsp;Hitung Material Requirement
                </a>

            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body">
            <?php
            if (session()->getFlashdata('pesan')) {
                echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('pesan');
                echo '</h5></div>';
            }
            ?>
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">No</th>
                            <th>Produksi</th>
                            <th>Order Number</th>
                            <th>Material</th>
                            <th>Gross Requirement</th>
                            <th>Net Requirement</th>
                            <th>Status</th>
                            <!-- <th width="100px">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1;
                        foreach ($strukturs as $key => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $value['product_name'] ?></td>
                                <td><?= $value['order_number'] ?></td>
                                <td><?= $value['material_name'] ?></td>
                                <td class="text-center"><?= $value['gross_requirement'] ?></td>
                                <td class="text-center"><?= $value['net_requirement'] ?></td>
                                <td class="text-center">
                                    <?php if ($value['status_material_requirement'] == 'pending') : ?>
                                        <span class="badge bg-secondary">Pending</span>
                                    <?php elseif ($value['status_material_requirement'] == 'fullfiled') : ?>
                                        <span class="badge bg-success">Fullfiled</span>
                                    <?php elseif ($value['status_material_requirement'] == 'partially') : ?>
                                        <span class="badge bg-warning">Fullfiled Partially</span>
                                    <?php endif; ?>
                                </td>
                                <!-- <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_material_requirement'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_material_requirement'] ?>"><i class="fas fa-trash"></i></button>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<hr class="my-5" />

<!-- Modal Add Data -->
<div class="modal fade" id="add-data" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Data <?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('Struktur/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Produksi</label>
                        <select name="production_planning_id" class="form-control">
                            <option value="">--Pilih Produksi--</option>
                            <?php foreach ($productions as $key => $value) { ?>
                                <option value="<?= $value['id'] ?>"><?= $value['order_number'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Material</label>
                        <select name="material_id" class="form-control">
                            <option value="">--Pilih Material--</option>
                            <?php foreach ($materials as $key => $material) { ?>
                                <option value="<?= $material['id_material'] ?>"><?= $material['material_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Net Requirement</label>
                        <input name="net_requirement" class="form-control" placeholder="Net Requirement" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="">Status</label>
                        <select name="status_material_requirement" class="form-control" required>
                            <option value="pending" selected>Pending</option>
                            <option value="fullfiled">Fullfiled</option>
                            <option value="partially">Partially Fullfiled</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
            </div>
            <?php echo form_close() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Edit Data -->
<?php foreach ($strukturs as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id_material_requirement'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('Struktur/UpdateData/' . $value['id_material_requirement']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Produksi</label>
                            <select name="production_planning_id" class="form-control">
                                <option value="">--Pilih Produksi--</option>
                                <?php foreach ($productions as $key => $k) { ?>
                                    <option value="<?= $k['id'] ?>" <?= $value['production_planning_id'] == $k['id'] ? 'selected' : '' ?>><?= $k['order_number'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Material</label>
                            <select name="material_id" class="form-control">
                                <option value="">--Pilih Material--</option>
                                <?php foreach ($materials as $key => $m) { ?>
                                    <option value="<?= $m['id_material'] ?>" <?= $value['material_id'] == $m['id_material'] ? 'selected' : '' ?>><?= $m['material_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Net Requirement</label>
                            <input name="net_requirement" value="<?= $value['net_requirement'] ?>" class="form-control" placeholder="Net Requirement" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="status_material_requirement" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="pending" <?= ($value['status_material_requirement'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="fullfiled" <?= ($value['status_material_requirement'] == 'fullfiled') ? 'selected' : ''; ?>>Fullfiled</option>
                                <option value="partially" <?= ($value['status_material_requirement'] == 'partially') ? 'selected' : ''; ?>>Partially Fullfiled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-flat">Update</button>
                </div>
                <?php echo form_close() ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>

<!-- Modal Delete Data -->
<?php foreach ($strukturs as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_material_requirement'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Data <?= $judul ?></h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['order_number'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Struktur/DeleteData/' . $value['id_material_requirement']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>