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
                            <th>Nama Produk</th>
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
                                    <button class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#detail-data<?= $value['id'] ?>"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit-data<?= $value['id'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <!-- <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#delete-data<?= $value['id'] ?>"><i class="fas fa-trash"></i></button> -->
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

<!-- Modal Detail MRP -->
<?php foreach ($productions as $production) : ?>
    <div class="modal fade" id="detail-data<?= $production['id'] ?>" tabindex="-1" aria-hidden="true">
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

                <div class="modal-body">
                    <h5>Pembahanan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Material</th>
                                    <th>Qty Dibutuhkan (Gross)</th>
                                    <th>Stok Tersedia</th>
                                    <th>Kekurangan (Net)</th>
                                    <th>Status</th>
                                    <th>Perbarui Status & Hitung Ulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($production['material_requirements'] as $detail) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $detail['material_name'] ?></td>
                                        <td><?= $detail['gross_requirement'] ?></td>
                                        <td><?= $detail['max_stock'] ?></td>
                                        <td><?= $detail['net_requirement'] ?></td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] == 'pending') : ?>
                                                <span class="badge bg-secondary">Pending</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'fullfiled') : ?>
                                                <span class="badge bg-success">Fullfiled</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'partially') : ?>
                                                <span class="badge bg-warning">Partially</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] != 'fullfiled') : ?>
                                                <a href="<?= base_url('Produksi/updateRequirement/' . $production['id']) ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-recycle"></i> Perbarui
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">Sudah Fullfiled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h5>Bentuk Dasar</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Material</th>
                                    <th>Qty Dibutuhkan (Gross)</th>
                                    <th>Stok Tersedia</th>
                                    <th>Kekurangan (Net)</th>
                                    <th>Status</th>
                                    <th>Perbarui Status & Hitung Ulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($production['materials2'] as $detail) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $detail['material_name'] ?></td>
                                        <td><?= $detail['gross_requirement'] ?></td>
                                        <td><?= $detail['max_stock'] ?></td>
                                        <td><?= $detail['net_requirement'] ?></td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] == 'pending') : ?>
                                                <span class="badge bg-secondary">Pending</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'fullfiled') : ?>
                                                <span class="badge bg-success">Fullfiled</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'partially') : ?>
                                                <span class="badge bg-warning">Partially</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] != 'fullfiled') : ?>
                                                <a href="<?= base_url('Produksi/updateRequirement/' . $production['id']) ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-recycle"></i> Perbarui
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">Sudah Fullfiled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h5>Rakit 1</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Material</th>
                                    <th>Qty Dibutuhkan (Gross)</th>
                                    <th>Stok Tersedia</th>
                                    <th>Kekurangan (Net)</th>
                                    <th>Status</th>
                                    <th>Perbarui Status & Hitung Ulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($production['materials3'] as $detail) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $detail['material_name'] ?></td>
                                        <td><?= $detail['gross_requirement'] ?></td>
                                        <td><?= $detail['max_stock'] ?></td>
                                        <td><?= $detail['net_requirement'] ?></td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] == 'pending') : ?>
                                                <span class="badge bg-secondary">Pending</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'fullfiled') : ?>
                                                <span class="badge bg-success">Fullfiled</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'partially') : ?>
                                                <span class="badge bg-warning">Partially</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] != 'fullfiled') : ?>
                                                <a href="<?= base_url('Produksi/updateRequirement/' . $production['id']) ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-recycle"></i> Perbarui
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">Sudah Fullfiled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h5>Finishing</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Material</th>
                                    <th>Qty Dibutuhkan (Gross)</th>
                                    <th>Stok Tersedia</th>
                                    <th>Kekurangan (Net)</th>
                                    <th>Status</th>
                                    <th>Perbarui Status & Hitung Ulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($production['materials4'] as $detail) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $detail['material_name'] ?></td>
                                        <td><?= $detail['gross_requirement'] ?></td>
                                        <td><?= $detail['max_stock'] ?></td>
                                        <td><?= $detail['net_requirement'] ?></td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] == 'pending') : ?>
                                                <span class="badge bg-secondary">Pending</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'fullfiled') : ?>
                                                <span class="badge bg-success">Fullfiled</span>
                                            <?php elseif ($detail['status_material_requirement'] == 'partially') : ?>
                                                <span class="badge bg-warning">Partially</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($detail['status_material_requirement'] != 'fullfiled') : ?>
                                                <a href="<?= base_url('Produksi/updateRequirement/' . $production['id']) ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-recycle"></i> Perbarui
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">Sudah Fullfiled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                    <?php
                    $allFullfiled = true;
                    foreach ($production['material_requirements'] as $detail) {
                        if ($detail['status_material_requirement'] !== 'fullfiled') {
                            $allFullfiled = false;
                            break;
                        }
                    }
                    ?>
                    <!-- CEK BOM ID NING KENE -->
                    <?php if ($allFullfiled) : ?>
                        <?php if (!empty($production['material_requirements']) && !empty($production['materials2'])) : ?>
                            <?php if ($production['process_step_log'] == '0' && $production['order_log'] == 'inprogress') : ?>
                                <button class="btn btn-success"
                                    onclick="openOrderProduksiModal(<?= $production['id'] ?>, '<?= $production['bom_id'] ?>', '<?= $production['quality'] ?>', <?= $production['product_id'] ?>)">
                                    <i class="fas fa-cogs"></i> Buat Order Produksi Tahap 1
                                </button>
                            <?php elseif ($production['process_step_log'] == '1' && $production['order_log'] == 'completed') : ?>
                                <button class="btn btn-success"
                                    onclick="openOrderProduksiModal2(<?= $production['id'] ?>, '<?= $production['bom_id_2'] ?>')">
                                    <i class="fas fa-cogs"></i> Buat Order Produksi Tahap 2
                                </button>
                            <?php elseif ($production['process_step_log'] == '2' && $production['order_log'] == 'completed') : ?>
                                <button class="btn btn-success"
                                    onclick="openOrderProduksiModal3(<?= $production['id'] ?>, '<?= $production['bom_id_3'] ?>')">
                                    <i class="fas fa-cogs"></i> Buat Order Produksi Tahap 3
                                </button>
                            <?php elseif ($production['process_step_log'] == '3' && $production['order_log'] == 'completed') : ?>
                                <button class="btn btn-success"
                                    onclick="openOrderProduksiModal4(<?= $production['id'] ?>, '<?= $production['bom_id_4'] ?>')">
                                    <i class="fas fa-cogs"></i> Buat Order Produksi Tahap 4
                                </button>
                            <?php elseif ($production['process_step_log'] == '4' && $production['order_log'] == 'completed') : ?>
                                <button class="btn btn-success" disabled>
                                    <i class="fas fa-check"></i> Produksi Selesai
                                </button>
                            <?php else : ?>
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-ban"></i> Proses Order
                                </button>
                            <?php endif; ?>
                        <?php else : ?>
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-ban"></i> BOM Belum Lengkap
                            </button>
                        <?php endif; ?>
                    <?php else : ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-ban"></i> Bahan Belum Lengkap
                        </button>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Buat Order Produksi Tahap 1 -->
<div class="modal fade" id="modalOrderProduksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Order Produksi Tahap 1</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <?php echo form_open('Order/InsertOrderTahap1') ?>
            <div class="modal-body">
                <input type="hidden" name="production_planning_id" id="orderProductionId">
                <input type="hidden" name="bom_id" id="orderBomId">
                <input type="hidden" name="productId" id="orderProductId">
                <!-- <input type="hidden" name="target_qty" id="orderQuality"> -->
                <div id="materialRequirementsContainer"></div>

                <?php
                function generateKodeOtomatis()
                {
                    $tanggal = date('Ymd');
                    $randomNumber = rand(100, 999); // angka acak
                    return 'ODR-' . $tanggal . $randomNumber;
                }

                $kodeBaru = generateKodeOtomatis();
                ?>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Order Number</label>
                        <input name="order_number" class="form-control" value="<?= $kodeBaru ?>" required>
                        <span>*Kode ter-generate otomatis</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Target Qty</label>
                        <input name="target_qty" class="form-control" id="orderQuality" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Planned Date</label>
                        <input type="date" name="planned_date_order" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="" class="form-label">Catatan</label>
                        <input type="text" name="notes_order" class="form-control" placeholder="Catatan" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Ya, Buat Order</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Buat Order Produksi Tahap 2 -->
<?php foreach ($productions as $production) : ?>
    <div class="modal fade" id="modalOrderProduksi2<?= $production['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Order Produksi Tahap 2</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <?php echo form_open('Order/InsertOrderTahap2') ?>
                <div class="modal-body">
                    <input type="hidden" name="production_planning_id" value="<?= $production['id'] ?>" id="productionId">
                    <input type="hidden" name="productId" value="<?= $production['product_id'] ?>">
                    <input type="hidden" name="bom_id_2" value="<?= $production['bom_id_2'] ?>" id="bom_id_2">
                    <div id="materialRequirementsContainer<?= $production['id'] ?>"></div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Order Number</label>
                            <input name="order_number" class="form-control" value="<?= $production['execution_stock']['order_number'] ?? '' ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Target Qty</label>
                            <input name="target_qty" class="form-control" value="<?= $production['execution_stock']['final_qty'] ?? '' ?>" readonly>
                            <span>*Final Qty pada Order <?= $production['product_name'] ?> Tahap 1</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Planned Date</label>
                            <input type="date" name="planned_date_order" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Catatan</label>
                            <input type="text" name="notes_order" class="form-control" placeholder="Catatan" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya, Buat Order</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Buat Order Produksi Tahap 3 -->
<?php foreach ($productions as $production) : ?>
    <div class="modal fade" id="modalOrderProduksi3<?= $production['id'] ?><?= $production['bom_id_3'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Order Produksi Tahap 3</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <?php echo form_open('Order/InsertOrderTahap3') ?>
                <div class="modal-body">
                    <input type="hidden" name="production_planning_id" value="<?= $production['id'] ?>" id="productionId">
                    <input type="hidden" name="productId" value="<?= $production['product_id'] ?>">
                    <input type="hidden" name="bom_id_3" value="<?= $production['bom_id_3'] ?>" id="bom_id_3">
                    <div id="materialRequirementsContainer<?= $production['id'] ?><?= $production['bom_id_3'] ?>"></div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Order Number</label>
                            <input name="order_number" class="form-control" value="<?= $production['execution_stock']['order_number'] ?? '' ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Target Qty</label>
                            <input name="target_qty" class="form-control" value="<?= $production['execution_stock']['final_qty'] ?? '' ?>" readonly>
                            <span>*Final Qty pada Order <?= $production['product_name'] ?> Tahap 2</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Planned Date</label>
                            <input type="date" name="planned_date_order" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Catatan</label>
                            <input type="text" name="notes_order" class="form-control" placeholder="Catatan" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya, Buat Order</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Buat Order Produksi Tahap 4 -->
<?php foreach ($productions as $production) : ?>
    <div class="modal fade" id="modalOrderProduksi4<?= $production['id'] ?><?= $production['bom_id_4'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Order Produksi Tahap 4</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <?php echo form_open('Order/InsertOrderTahap4') ?>
                <div class="modal-body">
                    <input type="hidden" name="production_planning_id" value="<?= $production['id'] ?>" id="productionId">
                    <input type="hidden" name="productId" value="<?= $production['product_id'] ?>">
                    <input type="hidden" name="bom_id_4" value="<?= $production['bom_id_4'] ?>" id="bom_id_4">
                    <div id="materialRequirementsContainer<?= $production['id'] ?><?= $production['bom_id_4'] ?>"></div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Order Number</label>
                            <input name="order_number" class="form-control" value="<?= $production['execution_stock']['order_number'] ?? '' ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Target Qty</label>
                            <input name="target_qty" class="form-control" value="<?= $production['execution_stock']['final_qty'] ?? '' ?>" readonly>
                            <span>*Final Qty pada Order <?= $production['product_name'] ?> Tahap 3</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Planned Date</label>
                            <input type="date" name="planned_date_order" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Catatan</label>
                            <input type="text" name="notes_order" class="form-control" placeholder="Catatan" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya, Buat Order</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    const productions = <?= json_encode($productions); ?>;

    function openOrderProduksiModal(productionId, bomId, quality, productId) {
        const production = productions.find(p => p.id == productionId);

        document.getElementById('orderProductionId').value = productionId;
        document.getElementById('orderBomId').value = bomId;
        document.getElementById('orderQuality').value = quality;
        document.getElementById('orderProductId').value = productId;

        const container = document.getElementById('materialRequirementsContainer');
        container.innerHTML = '';

        production.material_requirements.forEach((material, index) => {
            container.innerHTML += `
            <input type="hidden" name="materials[${index}][material_id]" value="${material.material_id}">
            <input type="hidden" name="materials[${index}][gross_requirement]" value="${material.gross_requirement}">
            <input type="hidden" name="materials[${index}][id_material_requirement]" value="${material.id_material_requirement}">
        `;
        });

        $('#modalOrderProduksi').modal('show');
    }

    function openOrderProduksiModal2(productionId, bom_id_2) {
        const production = productions.find(p => p.id == productionId && p.bom_id_2 == bom_id_2);
        // console.log(production);
        const container = document.getElementById('materialRequirementsContainer' + productionId);
        container.innerHTML = '';

        production.materials2.forEach((material, index) => {
            container.innerHTML += `
            <input type="hidden" name="materials[${index}][material_id]" value="${material.material_id}">
            <input type="hidden" name="materials[${index}][gross_requirement]" value="${material.gross_requirement}">
            <input type="hidden" name="materials[${index}][id_material_requirement]" value="${material.id_material_requirement}">
        `;
        });

        $('#modalOrderProduksi2' + productionId).modal('show');
    }

    function openOrderProduksiModal3(productionId, bom_id_3) {
        const production = productions.find(p => p.id == productionId && p.bom_id_3 == bom_id_3);
        const container = document.getElementById('materialRequirementsContainer' + productionId + bom_id_3);
        console.log(container);
        container.innerHTML = '';

        production.materials3.forEach((material, index) => {
            container.innerHTML += `
            <input type="hidden" name="materials[${index}][material_id]" value="${material.material_id}">
            <input type="hidden" name="materials[${index}][gross_requirement]" value="${material.gross_requirement}">
            <input type="hidden" name="materials[${index}][id_material_requirement]" value="${material.id_material_requirement}">
        `;
        });

        $('#modalOrderProduksi3' + productionId + bom_id_3).modal('show');
    }

    function openOrderProduksiModal4(productionId, bom_id_4) {
        const production = productions.find(p => p.id == productionId && p.bom_id_4 == bom_id_4);
        const container = document.getElementById('materialRequirementsContainer' + productionId + bom_id_4);
        // console.log(container);
        container.innerHTML = '';

        production.materials4.forEach((material, index) => {
            container.innerHTML += `
            <input type="hidden" name="materials[${index}][material_id]" value="${material.material_id}">
            <input type="hidden" name="materials[${index}][gross_requirement]" value="${material.gross_requirement}">
            <input type="hidden" name="materials[${index}][id_material_requirement]" value="${material.id_material_requirement}">
        `;
        });

        $('#modalOrderProduksi4' + productionId + bom_id_4).modal('show');
    }
</script>

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
                                    <input type="text" name="product_id" value="<?= $value['product_name'] ?>" class="form-control" readonly>
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