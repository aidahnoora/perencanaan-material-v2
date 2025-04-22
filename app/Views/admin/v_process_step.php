<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Proses Produksi</h3>

            <div class="card-tools">
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
                            <th>Nama Proses Produksi</th>
                            <th>Tahap</th>
                            <th>Deskripsi</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($process_steps as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['step_name'] ?></td>
                                <td class="text-center"><?= $value['step_order'] ?></td>
                                <td><?= $value['description'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_process_step'] ?>"><i class="fas fa-pencil-alt"></i></button>
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

<!-- Modal Edit Data -->
<?php foreach ($process_steps as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id_process_step'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Proses Produksi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('ProcessStep/UpdateData/' . $value['id_process_step']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nama Proses Produksi</label>
                                <input type="text" name="step_name" class="form-control" autofocus value="<?= $value['step_name'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Tahap</label>
                                <input type="text" name="step_order" class="form-control" value="<?= $value['step_order'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <input type="text" name="description" class="form-control" value="<?= $value['description'] ?>" required>
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