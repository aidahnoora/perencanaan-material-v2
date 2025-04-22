<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Hasil Produksi Tahap 4</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add-data"><i class="fas fa-plus"></i> Add Data
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
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
                            <th>Kode</th>
                            <th>Nama Material</th>
                            <th>Spesifikasi</th>
                            <th>Tipe</th>
                            <th>Grade</th>
                            <th>Standart Cost</th>
                            <th>BOM</th>
                            <th>Min. Stok</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($materials as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['material_code'] ?></td>
                                <td><?= $value['material_name'] ?></td>
                                <td><?= $value['material_spec'] ?></td>
                                <td><?= $value['material_type'] ?></td>
                                <td><?= $value['grade'] ?></td>
                                <td><?= $value['standard_cost'] ?></td>
                                <td><?= $value['bom'] ?></td>
                                <td class="text-center"><?= $value['min_stock'] ?></td>
                                <td class="text-center">
                                    <?php if ($value['max_stock'] < $value['min_stock']) : ?>
                                        <span class="badge bg-danger"><?= $value['max_stock'] ?></span>
                                    <?php elseif ($value['max_stock'] > $value['min_stock']) : ?>
                                        <?= $value['max_stock'] ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($value['status'] == 'available') : ?>
                                        <span class="badge bg-success">Available</span>
                                    <?php elseif ($value['status'] == 'out-of-stock') : ?>
                                        <span class="badge bg-warning">Out of Stock</span>
                                    <?php elseif ($value['status'] == 'discontinued') : ?>
                                        <span class="badge bg-danger">Discontinued</span>
                                    <?php endif; ?>
                                </td>
                                <!-- <td>
                                    <?php if ($value['max_stock'] > $value['min_stock']) : ?>
                                        <span class="badge bg-success">Available</span>
                                    <?php elseif ($value['max_stock'] < $value['min_stock']) : ?>
                                        <span class="badge bg-warning">Out of Stock</span>
                                    <?php elseif ($value['status'] == 'discontinued') : ?>
                                        <span class="badge bg-danger">Discontinued</span>
                                    <?php endif; ?>
                                </td> -->
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_material'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_material'] ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->


<!-- Modal Add Data -->
<div class="modal fade" id="add-data">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Data Hasil Finishing (Tahap 4)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('Material/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Kode Material</label>
                            <input type="text" name="material_code" class="form-control" placeholder="Kode Material" autofocus required>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Material</label>
                            <input type="text" name="material_name" class="form-control" placeholder="Nama Material" required>
                        </div>

                        <div class="form-group">
                            <label for="">Spesifikasi Material</label>
                            <input type="text" name="material_spec" class="form-control" placeholder="Spesifikasi Material" required>
                        </div>

                        <div class="form-group">
                            <label for="">Tipe Material</label>
                            <input type="text" name="material_type" class="form-control" placeholder="Tipe Material" required>
                        </div>

                        <div class="form-group">
                            <label for="">Grade</label>
                            <input type="text" name="grade" class="form-control" placeholder="Grade" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Standart Cost</label>
                            <input type="number" name="standard_cost" class="form-control" placeholder="Standart Cost" required>
                        </div>

                        <div class="form-group">
                            <label for="">BOM</label>
                            <input type="text" name="bom" class="form-control" value="Tahap 4" readonly>
                            <input type="hidden" name="type" value="tahap4">
                            <input type="hidden" name="source_process_step_id" value="4">
                        </div>

                        <div class="form-group">
                            <label for="">Min. Stok</label>
                            <input type="number" name="min_stock" class="form-control" placeholder="Min. Stok" required>
                        </div>

                        <div class="form-group">
                            <label for="">Stok</label>
                            <input type="number" name="max_stock" class="form-control" placeholder="Stok" required>
                        </div>

                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="available" selected>Available</option>
                                <option value="out-of-stock">Out of Stock</option>
                                <option value="discontinued">Discontinued</option>
                            </select>
                        </div>
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
<?php foreach ($materials as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id_material'] ?>">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('Material/UpdateData/' . $value['id_material']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Material</label>
                                <input type="text" name="material_code" class="form-control" autofocus value="<?= $value['material_code'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Nama Material</label>
                                <input type="text" name="material_name" class="form-control" value="<?= $value['material_name'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Spesifikasi Material</label>
                                <input type="text" name="material_spec" class="form-control" value="<?= $value['material_spec'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Tipe Material</label>
                                <input type="text" name="material_type" class="form-control" value="<?= $value['material_type'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Grade</label>
                                <input type="text" name="grade" class="form-control" value="<?= $value['grade'] ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Standart Cost</label>
                                <input type="number" name="standard_cost" class="form-control" value="<?= $value['standard_cost'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">BOM</label>
                                <input type="text" name="bom" class="form-control" value="<?= $value['bom'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Min. Stok</label>
                                <input type="number" name="min_stock" class="form-control" value="<?= $value['min_stock'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Stok</label>
                                <input type="number" name="max_stock" class="form-control" value="<?= $value['max_stock'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="available" <?= $value['status'] == 'available' ? 'Selected' : '' ?>>Available</option>
                                    <option value="out-of-stock" <?= $value['status'] == 'out-of-stock' ? 'Selected' : '' ?>>Out of Stock</option>
                                    <option value="discontinued" <?= $value['status'] == 'discontinued' ? 'Selected' : '' ?>>Discontinued</option>
                                </select>
                            </div>
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
<?php foreach ($materials as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_material'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['material_name'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Material/DeleteData/' . $value['id_material']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>