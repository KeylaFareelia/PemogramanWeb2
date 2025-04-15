<?php
include 'dbkoneksi.php';
$query = "SELECT * FROM pasien";
$stmt = $dbh->query($query);
$pasien = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <!-- Sertakan CSS AdminLTE / Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Data Pasien</h1>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <a href="form_pasien.php" class="btn btn-primary mb-3">Tambah Pasien</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Gender</th>
                                <th>Kelurahan</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pasien as $row): ?>
                            <tr>
                                <td><?= $row['kode']; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['tmp_lahir']; ?></td>
                                <td><?= $row['tgl_lahir']; ?></td>
                                <td><?= $row['gender']; ?></td>
                                <td><?= $row['klurahan']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['alamat']; ?></td>
                                <td>
                                    <!-- Link Edit dan Delete -->
                                    <a href="form_pasien.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="proses_pasien.php?delete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin akan menghapus data?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Sertakan JS AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
