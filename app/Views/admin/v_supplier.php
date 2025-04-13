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
                            <th>Nama Supplier</th>
                            <th>Kategori Material</th>
                            <th>CP</th>
                            <th>Email</th>
                            <th>No Hp</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($suppliers as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['supplier_code'] ?></td>
                                <td><?= $value['supplier_name'] ?></td>
                                <td><?= $value['material_category'] ?></td>
                                <td><?= $value['contact_person'] ?></td>
                                <td><?= $value['email'] ?></td>
                                <td><?= $value['phone'] ?></td>
                                <td><?= $value['address'] ?></td>
                                <td>
                                    <?php if ($value['status'] == 'active') : ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($value['status'] == 'inactive') : ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_supplier'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_supplier'] ?>"><i class="fas fa-trash"></i></button>
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
                <h4 class="modal-title">Add Data <?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('Supplier/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Kode Supplier</label>
                            <input type="text" name="supplier_code" class="form-control" placeholder="Kode Supplier" autofocus required>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Supplier</label>
                            <input type="text" name="supplier_name" class="form-control" placeholder="Nama Supplier" required>
                        </div>

                        <div class="form-group">
                            <label for="">Kategori Material</label>
                            <input type="text" name="material_category" class="form-control" placeholder="Kategori Material" required>
                        </div>

                        <div class="form-group">
                            <label for="">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" placeholder="Contact Person" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="text" name="email" class="form-control" placeholder="E-Mail" required>
                        </div>

                        <div class="form-group">
                            <label for="">Nomor Handphone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nomor Handphone" required>
                        </div>

                        <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" name="address" class="form-control" placeholder="Alamat" required>
                        </div>

                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="blacklisted">Blacklisted</option>
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
<?php foreach ($suppliers as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id_supplier'] ?>">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('Supplier/UpdateData/' . $value['id_supplier']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Supplier</label>
                                <input type="text" name="supplier_code" class="form-control" autofocus value="<?= $value['supplier_code'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Nama Supplier</label>
                                <input type="text" name="supplier_name" class="form-control" value="<?= $value['supplier_name'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Kategori Material</label>
                                <input type="text" name="material_category" class="form-control" value="<?= $value['material_category'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Contact Person</label>
                                <input type="text" name="contact_person" class="form-control" value="<?= $value['contact_person'] ?>" placeholder="Contact Person" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">E-Mail</label>
                                <input type="text" name="email" class="form-control" value="<?= $value['email'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Nomor Handphone</label>
                                <input type="text" name="phone" class="form-control" value="<?= $value['phone'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input type="text" name="address" class="form-control" value="<?= $value['address'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" <?= $value['status'] == 'active' ? 'Selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $value['status'] == 'inactive' ? 'Selected' : '' ?>>Inactive</option>
                                    <option value="blacklisted" <?= $value['status'] == 'blacklisted' ? 'Selected' : '' ?>>Blacklisted</option>
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
<?php foreach ($suppliers as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_supplier'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['supplier_name'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Supplier/DeleteData/' . $value['id_supplier']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>