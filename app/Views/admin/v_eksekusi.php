<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>

            <div class="card-tools">
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body">
            <?php if (session()->get('errors')): ?>
                <div class="alert alert-danger">
                    <?= session()->get('errors') ?>
                    <?php session()->remove('errors'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->get('pesan')): ?>
                <div class="alert alert-success">
                    <?= session()->get('pesan') ?>
                    <?php session()->remove('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">No</th>
                            <th>Order Number</th>
                            <th>Tahap</th>
                            <th>Status Eksekusi</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Catatan</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1;
                        foreach ($production_executions as $key => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $value['order_number'] ?></td>
                                <td class="text-center">Tahap <?= $value['step_order'] ?> (<?= $value['step_name'] ?>)</td>
                                <td class="text-center">
                                    <?php if ($value['status_execution'] == 'inprogress') : ?>
                                        <span class="badge bg-secondary">In Progress</span>
                                    <?php elseif ($value['status_execution'] == 'completed') : ?>
                                        <span class="badge bg-info">Completed</span>
                                    <?php elseif ($value['status_execution'] == 'rejected') : ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php elseif ($value['status_execution'] == 'approved') : ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif ($value['status_execution'] == 'awaiting_approval') : ?>
                                        <span class="badge bg-warning">Waiting for Approval</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $value['start_time'] ?></td>
                                <td class="text-center"><?= $value['end_time'] ?></td>
                                <td class="text-center"><?= $value['notes_execution'] ?></td>
                                <td class="text-center">
                                    <!-- <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id_production_execution'] ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button> -->
                                    <?php if ($value['status_execution'] == 'inprogress') : ?>
                                        <button class="btn btn-success btn-sm btn-flat" data-toggle="modal" data-target="#detail-data<?= $value['id_production_execution'] ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
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

<!-- Modal Ubah Status Eksekusi -->
<?php foreach ($production_executions as $production) : ?>
    <div class="modal fade" id="edit-data<?= $production['id_production_execution'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <?= $production['product_name'] ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php echo form_open('Eksekusi/UpdateData/' . $production['id_production_execution']) ?>
                <div class="modal-body">
                    <input type="hidden" name="production_execution_id" value="<?= $production['id_production_execution'] ?>">

                    <div class="form-group">
                        <label for="">Status Eksekusi Produksi</label>
                        <select name="status_execution" class="form-control" required>
                            <option value="inprogress" <?= $value['status_execution'] == 'inprogress' ? 'Selected' : '' ?>>In Progress</option>
                            <option value="done" <?= $value['status_execution'] == 'done' ? 'Selected' : '' ?>>Done</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning btn-flat">Update</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- Modal Kirim Approval -->
<?php foreach ($production_executions as $production) : ?>
    <div class="modal fade" id="detail-data<?= $production['id_production_execution'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <?= $production['product_name'] ?> - <?= $production['execution_stock']['step_name'] ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php echo form_open('Eksekusi/KirimApproval') ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <?php foreach ($production['execution_stocks'] as $fck) : ?>
                                <input type="hidden" name="execution_stock_id[]" value="<?= $fck['id_execution_stock'] ?>">
                                <input type="hidden" name="approved_qty[]" value="<?= $fck['qty_produced'] ?>">
                            <?php endforeach; ?>

                            <div class="table-responsive">
                                <table>
                                    <tr>
                                        <th>Order Number</th>
                                        <td width="5%" class="text-center">:</td>
                                        <td><?= $production['order_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Produk</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['product_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Proses</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['step_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Hasil Output Produksi</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['execution_stock']['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Output</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['execution_stock']['qty_produced'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Produkdi</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['planned_date_order'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>User Produksi</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['nama_user'] ?> (<?= $production['deskripsi'] ?>)</td>
                                    </tr>
                                    <tr>
                                        <th>Status Produksi</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['status_order'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya, Kirim untuk Approval</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>