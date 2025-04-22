<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>

            <div class="card-tools">
                <a href="<?= base_url('Laporan/print') ?>" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak PDF
                </a>
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

            <div class="table-responsive" id="printArea">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">No</th>
                            <th>Kode</th>
                            <th>Nama Material</th>
                            <th>BOM</th>
                            <th>Spesifikasi</th>
                            <th>Tipe</th>
                            <th>Grade</th>
                            <th>Standart Cost</th>
                            <th>BOM</th>
                            <th>Min. Stok</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($materials as $key => $value) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['material_code'] ?></td>
                                <td><?= $value['material_name'] ?></td>
                                <td><?= $value['bom'] ?></td>
                                <td><?= $value['material_spec'] ?></td>
                                <td><?= $value['material_type'] ?></td>
                                <td><?= $value['grade'] ?></td>
                                <td><?= $value['standard_cost'] ?></td>
                                <td><?= $value['bom'] ?></td>
                                <td class="text-center"><?= $value['min_stock'] ?></td>
                                <td class="text-center"><?= $value['max_stock'] ?></td>
                                <td>
                                    <?php if ($value['status'] == 'available') : ?>
                                        Available
                                    <?php elseif ($value['status'] == 'out-of-stock') : ?>
                                        Out of Stock
                                    <?php elseif ($value['status'] == 'discontinued') : ?>
                                        Discontinued
                                    <?php endif; ?>
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