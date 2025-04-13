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
            $errors = session()->getFlashdata('errors');
            if (!empty($errors)) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <ul>
                        <?php foreach ($errors as $key => $error) { ?>
                            <li><?= esc($error) ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

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
                            <th>Nama Produk</th>
                            <th>Spesifikasi Produk</th>
                            <th>Standart Cost</th>
                            <th>BOM</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($products as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['product_code'] ?></td>
                                <td><?= $value['product_name'] ?></td>
                                <td><?= $value['product_spec'] ?></td>
                                <td><?= $value['standard_cost'] ?></td>
                                <td><?= $value['bom'] ?></td>
                                <td><?= $value['category'] ?></td>
                                <td>
                                    <?php if ($value['status'] == 'active') : ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($value['status'] == 'inactive') : ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_product'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id_product'] ?>"><i class="fas fa-trash"></i></button>
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
            <?php echo form_open('Produk/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Kode Produk</label>
                            <input type="text" name="product_code" class="form-control" placeholder="Kode Produk" autofocus required>
                        </div>

                        <div class="form-group">
                            <label for="">Nama Produk</label>
                            <input type="text" name="product_name" class="form-control" placeholder="Nama Produk" required>
                        </div>

                        <div class="form-group">
                            <label for="">Spesifikasi Produk</label>
                            <input type="text" name="product_spec" class="form-control" placeholder="Spesifikasi Produk" required>
                        </div>

                        <div class="form-group">
                            <label for="">Standart Cost</label>
                            <input type="number" name="standard_cost" class="form-control" placeholder="Standart Cost" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">BOM</label>
                            <input type="text" name="bom" class="form-control" placeholder="BOM" required>
                        </div>

                        <div class="form-group">
                            <label for="">Kategori</label>
                            <input type="text" name="category" class="form-control" placeholder="Kategori" required>
                        </div>

                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
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
<?php foreach ($products as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id_product'] ?>">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('Produk/UpdateData/' . $value['id_product']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Produk</label>
                                <input type="text" name="product_code" class="form-control" autofocus value="<?= $value['product_code'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" name="product_name" class="form-control" value="<?= $value['product_name'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Spesifikasi Produk</label>
                                <input type="text" name="product_spec" class="form-control" value="<?= $value['product_spec'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Standart Cost</label>
                                <input type="number" name="standard_cost" class="form-control" value="<?= $value['standard_cost'] ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">BOM</label>
                                <input type="text" name="bom" class="form-control" value="<?= $value['bom'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Kategori</label>
                                <input type="text" name="category" class="form-control" value="<?= $value['category'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" <?= $value['status'] == 'active' ? 'Selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $value['status'] == 'inactive' ? 'Selected' : '' ?>>Inactive</option>
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
<?php foreach ($products as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id_product'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['product_name'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Produk/DeleteData/' . $value['id_product']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>