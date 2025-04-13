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
                            <th>Nama Produk</th>
                            <th>Order Number</th>
                            <th>Planned Date</th>
                            <th>Quality</th>
                            <th>Piority</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1;
                        foreach ($productions as $key => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $value['product_name'] ?></td>
                                <td class="text-center"><?= $value['order_number'] ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($value['planned_date'])) ?></td>
                                <td class="text-center"><?= $value['quality'] ?></td>
                                <td class="text-center"><?= $value['priority'] ?></td>
                                <td class="text-center">
                                    <?php if ($value['status_production'] == 'planned') : ?>
                                        <span class="badge bg-secondary">Planned</span>
                                    <?php elseif ($value['status_production'] == 'inprogress') : ?>
                                        <span class="badge bg-warning">In Progress</span>
                                    <?php elseif ($value['status_production'] == 'completed') : ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $value['notes'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id'] ?>"><i class="fas fa-trash"></i></button>
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Data <?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('Produksi/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Nama Produk</label>
                                <select name="product_id" class="form-control">
                                    <option value="">--Pilih Produk--</option>
                                    <?php foreach ($products as $key => $value) { ?>
                                        <option value="<?= $value['id_product'] ?>"><?= $value['product_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Order Number</label>
                                <input name="order_number" class="form-control" placeholder="Order Number" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Planned Date</label>
                                <input type="date" name="planned_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Quality</label>
                                <input name="quality" class="form-control" placeholder="Quality" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Priority</label>
                                <input name="priority" class="form-control" placeholder="Priority" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Status</label>
                                <select name="status_production" class="form-control" required>
                                    <option value="planned" selected>Planned</option>
                                    <option value="inprogress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="" class="form-label">Notes</label>
                                <input name="notes" class="form-control" placeholder="Notes" required>
                            </div>
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
<?php foreach ($productions as $key => $value) { ?>
    <div class="modal fade" id="edit-data<?= $value['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data <?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open('Produksi/UpdateData/' . $value['id']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Nama Produk</label>
                                    <select name="product_id" class="form-control">
                                        <option value="">--Pilih Produk--</option>
                                        <?php foreach ($products as $key => $k) { ?>
                                            <option value="<?= $k['id_product'] ?>" <?= $value['product_id'] == $k['id_product'] ? 'selected' : '' ?>><?= $k['product_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Order Number</label>
                                    <input name="order_number" value="<?= $value['order_number'] ?>" class="form-control" placeholder="Order Number" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Planned Date</label>
                                    <input type="date" name="planned_date" value="<?= $value['planned_date'] ?>" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Quality</label>
                                    <input name="quality" value="<?= $value['quality'] ?>" class="form-control" placeholder="Quality" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Priority</label>
                                    <input name="priority" value="<?= $value['priority'] ?>" class="form-control" placeholder="Priority" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select name="status_production" class="form-control">
                                        <option value="">--Pilih Status--</option>
                                        <option value="planned" <?= ($value['status_production'] == 'planned') ? 'selected' : ''; ?>>Planned</option>
                                        <option value="inprogress" <?= ($value['status_production'] == 'inprogress') ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="completed" <?= ($value['status_production'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Notes</label>
                                    <input name="notes" value="<?= $value['notes'] ?>" class="form-control" placeholder="Notes" required>
                                </div>
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
<?php foreach ($productions as $key => $value) { ?>
    <div class="modal fade" id="delete-data<?= $value['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Data <?= $judul ?></h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    Apakah Anda Yakin Hapus <b><?= $value['product_name'] ?></b> ..?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Produksi/DeleteData/' . $value['id']) ?>" class="btn btn-danger btn-flat">Delete</a>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php } ?>