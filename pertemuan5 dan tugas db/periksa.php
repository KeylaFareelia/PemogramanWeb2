<?php
include 'dbkoneksi.php';

// --- PROSES SIMPAN / UPDATE ---
if (isset($_POST['simpan'])) {
    $data = [
        $_POST['tanggal'],
        $_POST['berat_badan'], // sudah diganti
        $_POST['tinggi'],
        $_POST['tensi'],
        $_POST['keterangan'],
        $_POST['pasieen_id'],
        $_POST['dokter_id']
    ];

    if (!empty($_POST['id'])) {
        $data[] = $_POST['id'];
        $sql = "UPDATE periksaa SET tanggal=?, berat_badan=?, tinggi=?, tensi=?, keterangan=?, pasien_id=?, dokter_id=? WHERE id=?";
    } else {
        $sql = "INSERT INTO periksaa (tanggal, berat_badan, tinggi, tensi, keterangan, pasien_id, dokter_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    header("Location: periksaa.php");
    exit;
}

// --- PROSES HAPUS ---
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $stmt = $dbh->prepare("DELETE FROM periksaa WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: periksaa.php");
    exit;
}

// --- AMBIL DATA UNTUK FORM EDIT ---
$id = $_GET['id'] ?? null;
$edit_data = null;
if ($id) {
    $stmt = $dbh->prepare("SELECT * FROM periksaa WHERE id = ?");
    $stmt->execute([$id]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// --- AMBIL DATA DROPDOWN & TABEL ---
$pasien = $dbh->query("SELECT id, nama FROM pasieen")->fetchAll(PDO::FETCH_ASSOC);
$dokter = $dbh->query("SELECT id, nama FROM paramedikk")->fetchAll(PDO::FETCH_ASSOC);
$periksaa = $dbh->query("SELECT * FROM periksaa")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Periksa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link"><span class="brand-text font-weight-light">Dashboard Puskesmas</span></a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item"><a href="form_pasien.php" class="nav-link"><i class="nav-icon fas fa-user-plus"></i><p>Form Pasien</p></a></li>
                    <li class="nav-item"><a href="kelurahan.php" class="nav-link"><i class="nav-icon fas fa-map-marker-alt"></i><p>Kelurahan</p></a></li>
                    <li class="nav-item"><a href="paramedis.php" class="nav-link"><i class="nav-icon fas fa-user-md"></i><p>Paramedis</p></a></li>
                    <li class="nav-item"><a href="pasien.php" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Pasien</p></a></li>
                    <li class="nav-item"><a href="periksaa.php" class="nav-link active"><i class="nav-icon fas fa-stethoscope"></i><p>Periksa</p></a></li>
                    <li class="nav-item"><a href="unit_kerja.php" class="nav-link"><i class="nav-icon fas fa-building"></i><p>Unit Kerja</p></a></li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <section class="content-header"><h1 class="ml-3 mt-3">Data Periksa</h1></section>
        <section class="content">
            <div class="row m-3">
                <div class="col-md-12">

                    <!-- FORM -->
                    <div class="card mb-4" id="form-periksaa" style="<?= $edit_data ? '' : 'display:none;' ?>">
                        <div class="card-header bg-primary text-white"><?= $edit_data ? 'Edit' : 'Tambah' ?> Data Periksa</div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" value="<?= $edit_data['tanggal'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Berat (kg)</label>
                                    <input type="number" name="berat_badan" class="form-control" value="<?= $edit_data['berat_badan'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Tinggi (cm)</label>
                                    <input type="number" name="tinggi" class="form-control" value="<?= $edit_data['tinggi'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Tensi</label>
                                    <input type="text" name="tensi" class="form-control" value="<?= $edit_data['tensi'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control"><?= $edit_data['keterangan'] ?? '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pasien</label>
                                    <select name="pasieen_id" class="form-control" required>
                                        <option value="">-- Pilih Pasien --</option>
                                        <?php foreach ($pasien as $p): ?>
                                            <option value="<?= $p['id'] ?>" <?= ($edit_data['pasien_id'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Dokter</label>
                                    <select name="dokter_id" class="form-control" required>
                                        <option value="">-- Pilih Paramedis --</option>
                                        <?php foreach ($dokter as $d): ?>
                                            <option value="<?= $d['id'] ?>" <?= ($edit_data['dokter_id'] ?? '') == $d['id'] ? 'selected' : '' ?>><?= $d['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                                <a href="periksaa.php" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- TABEL -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <span>Daftar Pemeriksaan</span>
                            <button class="btn btn-success btn-sm" onclick="showForm()">+ Tambah Data Periksa</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Berat</th>
                                        <th>Tinggi</th>
                                        <th>Tensi</th>
                                        <th>Pasien</th>
                                        <th>Dokter</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($periksaa): ?>
                                        <?php foreach ($periksaa as $row): ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= $row['tanggal']; ?></td>
                                                <td><?= $row['berat_badan']; ?></td>
                                                <td><?= $row['tinggi']; ?></td>
                                                <td><?= $row['tensi']; ?></td>
                                                <td><?= $row['pasien_id']; ?></td>
                                                <td><?= $row['dokter_id']; ?></td>
                                                <td>
                                                    <a href="periksaa.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="periksaa.php?delete&id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
function showForm() {
    document.getElementById('form-periksaa').style.display = 'block';
    window.scrollTo(0, 0);
}
</script>
</body>
</html>
