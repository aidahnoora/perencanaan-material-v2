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
                            <th>Produk</th>
                            <th>Proses/Tahap</th>
                            <th>Output</th>
                            <th>Jumlah Diproduksi</th>
                            <th>Jumlah Realisasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1;
                        foreach ($execution_stocks as $key => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $value['order_number'] ?></td>
                                <td><?= $value['product_name'] ?></td>
                                <td class="text-center"><?= $value['step_name'] ?>/<?= $value['step_order'] ?></td>
                                <td><?= $value['name'] ?></td>
                                <td class="text-center"><?= $value['qty_produced'] ?></td>
                                <td class="text-center">
                                    <?= $value['final_qty'] !== null ? $value['final_qty'] : '<span class="badge bg-danger">Belum ACC</span>' ?>
                                </td>
                                <td class="text-center"><?= $value['planned_date_order'] ?></td>
                                <td class="text-center">
                                    <?php if ($value['status'] == 'pending') : ?>
                                        <span class="badge bg-secondary">Pending</span>
                                    <?php elseif ($value['status'] == 'partial') : ?>
                                        <span class="badge bg-info">Partial</span>
                                    <?php elseif ($value['status'] == 'rejected') : ?>
                                        <span class="badge bg-warning">Rejected</span>
                                    <?php elseif ($value['status'] == 'approved') : ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#detail-data<?= $value['id_execution_stock'] ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if ($value['status'] == 'pending') : ?>
                                        <button class="btn btn-success btn-sm btn-flat" data-toggle="modal" data-target="#approval-data<?= $value['id_execution_stock'] ?>">
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

<!-- Modal Detail MRP -->
<?php foreach ($execution_stocks as $production) : ?>
    <div class="modal fade" id="detail-data<?= $production['id_execution_stock'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Realisasi <?= $production['name'] ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Approval</th>
                                    <th>Approved Qty</th>
                                    <th>Rejected Qty</th>
                                    <th>Catatan</th>
                                    <th>Role</th>
                                    <th>Tanggal Approve</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($production['execution_approvals'] as $detail) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $detail['approved_by'] ?></td>
                                        <td><?= $detail['approved_qty'] ?></td>
                                        <td><?= $detail['rejected_qty'] ?></td>
                                        <td><?= $detail['notes_approval'] ?></td>
                                        <td>
                                            <?php if ($detail['role'] == 'spv') : ?>
                                                <span class="badge bg-secondary">SPV</span>
                                            <?php elseif ($detail['role'] == 'qc') : ?>
                                                <span class="badge bg-success">QC</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $detail['approve_at'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Kirim Approval -->
<?php foreach ($execution_stocks as $production) : ?>
    <div class="modal fade" id="approval-data<?= $production['id_execution_stock'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <?= $production['product_name'] ?> - <?= $production['step_name'] ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php echo form_open('Approval/InsertData') ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" name="execution_stock_id" value="<?= $production['id_execution_stock'] ?>">

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
                                        <td><?= $production['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Output</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['qty_produced'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Produkdi</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['planned_date_order'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status Produksi</th>
                                        <td class="text-center">:</td>
                                        <td><?= $production['status'] ?></td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <div class="text-center">
                                <h5><b>Form Approval</b></h5>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Approved Quantity</label>
                                    <input type="number" name="approved_qty" class="form-control" value="0" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="" class="form-label">Rejected Quantity</label>
                                    <input type="number" name="rejected_qty" class="form-control" value="0" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Catatan</label>
                                    <input type="text" name="notes_approval" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.form.submit();">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>