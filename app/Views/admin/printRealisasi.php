<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Realisasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        h3 {
            text-align: center;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <h3>Laporan Realisasi</h3>
    <div class="table-responsive" id="printArea">
        <table class="table">
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

</body>

</html>