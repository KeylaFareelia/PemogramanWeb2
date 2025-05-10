<?php
include 'dbkoneksi.php';

// Tambah data unit kerja
if (isset($_POST['submit'])) {
    $kode_unit = $_POST['kode_unit'];
    $nama_unit = $_POST['nama_unit'];
    $keterangan = $_POST['keterangan'];

    // Pastikan nama tabelnya benar
    $query = "INSERT INTO unitt_kerja (kode_unit, nama_unit, keterangan) VALUES (?, ?, ?)";
    $stmt = $dbh->prepare($query);
    $stmt->execute([$kode_unit, $nama_unit, $keterangan]);

    header("Location: unit_php.php");
    exit;
}

// Edit data unit kerja
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kode_unit = $_POST['kode_unit'];
    $nama_unit = $_POST['nama_unit'];
    $keterangan = $_POST['keterangan'];

    // Pastikan nama tabelnya benar
    $query = "UPDATE unitt_kerja SET kode_unit=?, nama_unit=?, keterangan=? WHERE id=?";
    $stmt = $dbh->prepare($query);
    $stmt->execute([$kode_unit, $nama_unit, $keterangan, $id]);

    header("Location: unit_php.php");
    exit;
}

// Hapus data unit kerja
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    try {
        // Pastikan nama tabelnya benar
        $query = "DELETE FROM unitt_kerja WHERE id=?";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);

        header("Location: unit_php.php");
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Data tidak bisa dihapus karena masih digunakan oleh data lain!'); window.location='unit_php.php';</script>";
    }
}

// Ambil data unit kerja
$query = "SELECT * FROM unitt_kerja";
$stmt = $dbh->query($query);
$unittkerja = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data untuk form edit jika ada
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = "SELECT * FROM unitt_kerja WHERE id=?";
    $stmt = $dbh->prepare($query);
    $stmt->execute([$id]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unit Kerja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">Dashboard Klinik</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <!-- Sidebar items -->
                    <li class="nav-item">
                        <a href="unit_php.php" class="nav-link active">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Unit Kerja</p>
                        </a>
                    </li>
                    <!-- Other items -->
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1 class="ml-3 mt-3">Unit Kerja</h1>
        </section>

        <section class="content">
            <div class="card m-3">
                <div class="card-body">
                    <button class="btn btn-success" onclick="document.getElementById('form-container').style.display='block'">
                        <i class="fas fa-plus"></i> Tambah Unit Kerja
                    </button>
                </div>
            </div>

            <div class="card m-3" id="form-container" style="display: <?= $edit_data ? 'block' : 'none'; ?>;">
                <div class="card-body">
                    <form action="unit_php.php" method="POST">
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="id" value="<?= $edit_data['id']; ?>">
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="kode_unit">Kode Unit</label>
                            <input type="text" class="form-control" name="kode_unit" value="<?= $edit_data['kode_unit'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_unit">Nama Unit</label>
                            <input type="text" class="form-control" name="nama_unit" value="<?= $edit_data['nama_unit'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" required><?= $edit_data['keterangan'] ?? ''; ?></textarea>
                        </div>
                        <button type="submit" name="<?= $edit_data ? 'update' : 'submit'; ?>" class="btn btn-<?= $edit_data ? 'warning' : 'primary'; ?>">
                            <?= $edit_data ? 'Update' : 'Simpan'; ?>
                        </button>
                        <?php if ($edit_data): ?>
                            <a href="unit_php.php" class="btn btn-secondary">Batal</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card m-3">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Nama Unit</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($unittkerja as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['kode_unit']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_unit']); ?></td>
                                    <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                    <td>
                                        <a href="unit_php.php?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="unit_php.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($unittkerja)): ?>
                                <tr><td colspan="5" class="text-center">Belum ada data unit kerja.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
