<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Laporan Realisasi</h3>

            <div class="card-tools">
                <a href="<?= base_url('Laporan/printRealisasi') ?>" class="btn btn-danger btn-sm" target="_blank">
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
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Tahap</th>
                            <th>No. Order</th>
                            <th>Tanggal Order</th>
                            <th>Qty Disetujui</th>
                            <th>Qty Ditolak</th>
                            <th>Realisasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($laporan as $item) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->product_name ?></td>
                                <td class="text-center"><?= $item->process_step_id ?></td>
                                <td><?= $item->order_number ?></td>
                                <td class="text-center"><?= $item->planned_date_order ?></td>
                                <td class="text-center"><?= $item->approved_qty ?></td>
                                <td class="text-center"><?= $item->rejected_qty ?></td>
                                <td class="text-center"><?= $item->final_qty ?></td>
                                <td><?= ucfirst($item->status) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->