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
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Catatan</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1;
                        foreach ($production_orders as $key => $value) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $value['order_number'] ?></td>
                                <td class="text-center">Tahap <?= $value['step_order'] ?> (<?= $value['step_name'] ?>)</td>
                                <td><?= $value['product_name'] ?></td>
                                <td class="text-center"><?= $value['target_qty'] ?></td>
                                <td class="text-center">
                                    <?php if ($value['status_order'] == 'planned') : ?>
                                        <span class="badge bg-secondary">Planned</span>
                                    <?php elseif ($value['status_order'] == 'inprogress') : ?>
                                        <span class="badge bg-warning">In Progress</span>
                                    <?php elseif ($value['status_order'] == 'completed') : ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($value['planned_date_order'])) ?></td>
                                <td class="text-center"><?= $value['notes_order'] ?></td>
                                <td class="text-center">
                                    <?php if ($value['status_order'] == 'planned') : ?>
                                        <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#detail-data<?= $value['id_production_order'] ?>">
                                            <i class="fas fa-cog"></i> Eksekusi
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

<!-- Modal Eksekusi -->
<?php foreach ($production_orders as $production) : ?>
    <div class="modal fade" id="detail-data<?= $production['id_production_order'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <?= $production['product_name'] ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php echo form_open('Eksekusi/InsertData') ?>
                <div class="modal-body">
                    <input type="hidden" name="production_order_id" value="<?= $production['id_production_order'] ?>">
                    <input type="hidden" name="production_planning_id" value="<?= $production['production_planning_id'] ?>">
                    <input type="hidden" name="process_step_id" value="<?= $production['process_step_id'] ?>">
                    <input type="hidden" name="status_execution" value="inprogress">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Mulai</label>
                                    <input type="datetime-local" name="start_time" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Selesai</label>
                                    <input type="datetime-local" name="end_time" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Catatan</label>
                                    <input type="text" name="notes_execution" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Input Material</label>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Material</th>
                                                <th>Qty Pakai</th>
                                                <th>Source</th>
                                            </tr>
                                        </thead>
                                        <tbody id="edit-bom-details-">
                                            <?php $no = 1; ?>
                                            <?php foreach ($production['production_order_details'] as $detail) : ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="material_id[]" value="<?= $detail['material_id'] ?>">
                                                        <input type="text" class="form-control" placeholder="<?= $detail['material_name'] ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qty_used[]" class="form-control" value="<?= $detail['final_qty'] ?? $detail['gross_requirement'] ?>" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="source_type[]" class="form-control" value="material" readonly>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="qty_produced" value="<?= $production['target_qty'] ?>">

                        <div class="col-md-4">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="" class="form-label">Output Tahap <?= $production['step_order'] ?></label>
                                    <select name="output_id" class="form-control" required>
                                        <option value="">-- Select Material Output--</option>
                                        <?php foreach ($production['outputs'] as $key => $value) { ?>
                                            <option value="<?= $value['id_material'] ?>"><?= $value['material_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya, Eksekusi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>