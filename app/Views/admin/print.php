<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Stok</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; font-size: 12px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; }
        h3 { text-align: center; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <h3>Laporan Stok</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Material</th>
                <th>BOM</th>
                <th>Spesifikasi</th>
                <th>Tipe</th>
                <th>Grade</th>
                <th>Standart Cost</th>
                <th>Min. Stok</th>
                <th>Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($materials as $m) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $m['material_code'] ?></td>
                <td><?= $m['material_name'] ?></td>
                <td><?= $m['bom'] ?></td>
                <td><?= $m['material_spec'] ?></td>
                <td><?= $m['material_type'] ?></td>
                <td><?= $m['grade'] ?></td>
                <td><?= $m['standard_cost'] ?></td>
                <td><?= $m['min_stock'] ?></td>
                <td><?= $m['max_stock'] ?></td>
                <td><?= $m['status'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
