<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">BOM Tahap 4</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#add-bom">
                    <i class="fas fa-plus"></i> Add BOM
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('pesan'); ?></h5>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">No</th>
                            <th>Proses Produksi</th>
                            <th>BOM Code</th>
                            <th>Product Name</th>
                            <th>Effective Date</th>
                            <th>Total Material</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($boms as $bom) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $bom['step_name'] ?></td>
                                <td><?= $bom['bom_code'] ?></td>
                                <td><?= $bom['product_name'] ?> - <?= $bom['step_name'] ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($bom['effective_date'])) ?></td>
                                <td class="text-center"><?= count($bom['bom_details']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail-bom<?= $bom['id_bom'] ?>"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-bom<?= $bom['id_bom'] ?>"><i class="fas fa-pencil-alt"></i></button>
                                    <!-- <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-bom<?= $bom['id_bom'] ?>"><i class="fas fa-trash"></i></button> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add BOM -->
<div class="modal fade" id="add-bom" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add BOM</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Bom/InsertData') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="process_step_id" value="4">
                        <div class="mb-3">
                            <label class="form-label">BOM Code</label>
                            <input name="bom_code" class="form-control" placeholder="BOM Code" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">BOM Version</label>
                            <input name="bom_version" class="form-control" placeholder="BOM Version" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product</label>
                    <select name="product_id" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?= $product['id_product'] ?>"><?= $product['product_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <di class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Effective Date</label>
                            <input type="date" name="effective_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Approved By</label>
                            <input name="approved_by" class="form-control" placeholder="Approved By" required>
                        </div>
                    </div>
                </di>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <input name="notes" class="form-control" placeholder="Notes" required>
                </div>

                <!-- BOM Detail Section -->
                <hr>
                <h5>Add BOM Details</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Material</th>
                            <th>Quantity</th>
                            <th>Level</th>
                            <th>Process Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="bom-details">
                        <tr>
                            <td>
                                <!-- tambah tampilkan juga dari hasil tahap 3 -->
                                <select name="material_id[]" class="form-control" required>
                                    <option value="">-- Select Material --</option>
                                    <?php foreach ($materials as $material) : ?>
                                        <option value="<?= $material['id_material'] ?>"><?= $material['material_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantity_needed[]" class="form-control" placeholder="0" required>
                            </td>
                            <td>
                                <input type="number" name="level[]" class="form-control" placeholder="0" required>
                            </td>
                            <td>
                                <input type="text" name="proces_notes[]" class="form-control" placeholder="Notes" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-row">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" id="add-row">+ Add Material</button>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Detail BOM -->
<?php foreach ($boms as $bom) : ?>
    <div class="modal fade" id="detail-bom<?= $bom['id_bom'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail BOM: <?= $bom['product_name'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Level</th>
                                <th>Process Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($bom['bom_details'] as $detail) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $detail['material_name'] ?></td>
                                    <td class="text-center"><?= $detail['quantity_needed'] ?></td>
                                    <td class="text-center"><?= $detail['level'] ?></td>
                                    <td><?= $detail['proces_notes'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Edit BOM -->
<?php foreach ($boms as $bom) : ?>
    <div class="modal fade" id="edit-bom<?= $bom['id_bom'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit BOM: <?= $bom['bom_code'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('Bom/update/' . $bom['id_bom'] . '/' . $bom['process_step_id']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">BOM Code</label>
                                <input name="bom_code" class="form-control" value="<?= $bom['bom_code'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">BOM Version</label>
                                <input name="bom_version" class="form-control" value="<?= $bom['bom_version'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?= $product['id_product'] ?>" <?= $bom['product_id'] == $product['id_product'] ? 'selected' : '' ?>>
                                    <?= $product['product_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Effective Date</label>
                                <input type="date" name="effective_date" class="form-control" value="<?= $bom['effective_date'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Approved By</label>
                                <input name="approved_by" class="form-control" value="<?= $bom['approved_by'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <input name="notes" class="form-control" value="<?= $bom['notes'] ?>" required>
                    </div>

                    <!-- BOM Detail Section -->
                    <hr>
                    <h5>Edit BOM Details</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Level</th>
                                <th>Process Notes</th>
                            </tr>
                        </thead>
                        <tbody id="edit-bom-details-<?= $bom['id_bom'] ?>">
                            <?php foreach ($bom['bom_details'] as $detail) : ?>
                                <tr>
                                    <td>
                                        <select name="material_id[]" class="form-control" required>
                                            <option value="">-- Select Material --</option>
                                            <?php foreach ($materials as $material) : ?>
                                                <option value="<?= $material['id_material'] ?>" <?= $detail['material_id'] == $material['id_material'] ? 'selected' : '' ?>>
                                                    <?= $material['material_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="quantity_needed[]" class="form-control" value="<?= $detail['quantity_needed'] ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" name="level[]" class="form-control" value="<?= $detail['level'] ?>" required>
                                    </td>
                                    <td>
                                        <input type="text" name="proces_notes[]" class="form-control" value="<?= $detail['proces_notes'] ?>" required>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Delete BOM -->
<?php foreach ($boms as $bom) : ?>
    <div class="modal fade" id="delete-bom<?= $bom['id_bom'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Delete BOM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus <strong><?= $bom['bom_code'] ?></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('Bom/DeleteData/' . $bom['id_bom']) ?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tambah baris BOM Detail
        document.getElementById("add-row").addEventListener("click", function() {
            let row = `
                <tr>
                    <td>
                        <select name="material_id[]" class="form-control" required>
                            <option value="">-- Select Material --</option>
                            <?php foreach ($materials as $material) : ?>
                                <option value="<?= $material['id_material'] ?>"><?= $material['material_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantity_needed[]" class="form-control" placeholder="0" required>
                    </td>
                    <td>
                        <input type="number" name="level[]" class="form-control" placeholder="0" required>
                    </td>
                    <td>
                         <input type="text" name="proces_notes[]" class="form-control" placeholder="Notes" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            document.getElementById("bom-details").insertAdjacentHTML("beforeend", row);
        });

        // Hapus baris BOM Detail
        document.getElementById("bom-details").addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-row")) {
                e.target.closest("tr").remove();
            }
        });
    });
</script>