<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add-data"><i class="fas fa-plus"></i> Add Data
                </button>
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
                            <th>Material</th>
                            <th>Current Stock</th>
                            <th>Allocated Qty</th>
                            <th>Warehouse Location</th>
                            <th>Batch Number</th>
                            <th>Last Update</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1;
                        foreach ($inventories as $key => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $value['material_name'] ?></td>
                                <td class="text-center"><?= $value['current_stock'] ?></td>
                                <td class="text-center"><?= $value['allocated_qty'] ?></td>
                                <td class="text-center"><?= $value['warehouse_location'] ?></td>
                                <td class="text-center"><?= $value['batch_number'] ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($value['last_update'])) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_inventory'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_inventory'] ?>"><i class="fas fa-trash"></i></button>
                                </td>
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
            <?php echo form_open('Pembelian/InsertData') ?>
            <div class="modal-body">
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
                        <label for="" class="form-label">Current Stock</label>
                        <input name="current_stock" class="form-control" placeholder="Current Stock" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Allocated Qty</label>
                        <input name="allocated_qty" class="form-control" placeholder="Allocated Qty" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Warehouse Location</label>
                        <input name="warehouse_location" class="form-control" placeholder="Warehouse Location" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Batch Number</label>
                        <input name="batch_number" class="form-control" placeholder="Batch Number" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Last Update</label>
                        <input type="date" name="last_update" class="form-control" required>
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
<?php foreach ($inventories as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id_inventory'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('Pembelian/UpdateData/' . $value['id_inventory']) ?>
                <div class="modal-body">
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
                            <label for="" class="form-label">Current Stock</label>
                            <input name="current_stock" value="<?= $value['current_stock'] ?>" class="form-control" placeholder="Current Stock" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Allocated Qty</label>
                            <input name="allocated_qty" value="<?= $value['allocated_qty'] ?>" class="form-control" placeholder="Allocated Qty" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Warehouse Location</label>
                            <input name="warehouse_location" value="<?= $value['warehouse_location'] ?>" class="form-control" placeholder="Warehouse Location" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Batch Number</label>
                            <input name="batch_number" value="<?= $value['batch_number'] ?>" class="form-control" placeholder="Batch Number" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Last Update</label>
                            <input type="date" name="last_update" value="<?= $value['last_update'] ?>" class="form-control" required>
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
<?php foreach ($inventories as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_inventory'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Data <?= $judul ?></h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['material_name'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Pembelian/DeleteData/' . $value['id_inventory']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>