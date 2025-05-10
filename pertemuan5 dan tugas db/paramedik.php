<?php
// Koneksi ke database
try {
    $dbh = new PDO("mysql:host=localhost;dbname=dbpuskesmas", "root", "");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

session_start();

// --- DELETE data ---
if (isset($_GET['delete']) && isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $dbh->prepare("DELETE FROM paramedikk WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: paramedik.php');
    exit;
}

// --- Ambil data untuk EDIT ---
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$paramedikk = [];
if ($id) {
    $stmt = $dbh->prepare("SELECT * FROM paramedikk WHERE id = ?");
    $stmt->execute([$id]);
    $paramedikk = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$paramedikk) {
        header('Location: paramedik.php');
        exit;
    }
}

// --- Ambil semua unit kerja ---
$stmtUnit = $dbh->query("SELECT id, kode_unit FROM unitt_kerja");
$unitkerjaList = $stmtUnit->fetchAll(PDO::FETCH_ASSOC);

// --- SIMPAN / UPDATE data ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        $_POST['nama'] ?? '',
        $_POST['gender'] ?? '',
        $_POST['tmp_lahir'] ?? '',
        $_POST['tgr_lahir'] ?? '',  // Ganti tgl_lahir dengan tgr_lahir
        $_POST['kategori'] ?? '',
        $_POST['telepon'] ?? '',  // Ganti telpon dengan telepon
        $_POST['alamat'] ?? '',
        $_POST['unittkerja_id'] ?? ''
    ];

    if (isset($_POST['simpan'])) {
        $sql = "INSERT INTO paramedikk (nama, gender, tmp_lahir, tgr_lahir, kategori, telepon, alamat, unittkerja_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        header('Location: paramedik.php');
        exit;
    }

    if (isset($_POST['update']) && isset($_POST['id'])) {
        $data[] = $_POST['id'];
        $sql = "UPDATE paramedikk SET 
                nama=?, gender=?, tmp_lahir=?, tgr_lahir=?, kategori=?, telepon=?, alamat=?, unittkerja_id=? 
                WHERE id=?";
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        header('Location: paramedik.php');
        exit;
    }
}

// --- Ambil semua data paramedikk ---
$query = "SELECT p.*, u.kode_unit AS unit_nama 
          FROM paramedikk p 
          LEFT JOIN unitt_kerja u ON p.unittkerja_id = u.id";
$stmt = $dbh->query($query);
$paramedikkList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Paramedik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        label {
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
        }

        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .confirm {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Form Paramedik</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $paramedikk['id'] ?? '' ?>">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?= $paramedikk['nama'] ?? '' ?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Laki-laki" <?= (isset($paramedikk['gender']) && $paramedikk['gender'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
            <option value="Perempuan" <?= (isset($paramedikk['gender']) && $paramedikk['gender'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
        </select>

        <label>Tempat Lahir:</label>
        <input type="text" name="tmp_lahir" value="<?= $paramedikk['tmp_lahir'] ?? '' ?>" required>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tgr_lahir" value="<?= $paramedikk['tgr_lahir'] ?? '' ?>" required>

        <label>Kategori:</label>
        <input type="text" name="kategori" value="<?= $paramedikk['kategori'] ?? '' ?>" required>

        <label>Telepon:</label>
        <input type="text" name="telepon" value="<?= $paramedikk['telepon'] ?? '' ?>" required>

        <label>Alamat:</label>
        <textarea name="alamat" required><?= $paramedikk['alamat'] ?? '' ?></textarea>

        <label>Unit Kerja:</label>
        <select name="unittkerja_id" required>
            <?php foreach ($unitkerjaList as $unit): ?>
                <option value="<?= $unit['id'] ?>" <?= (isset($paramedikk['unittkerja_id']) && $paramedikk['unittkerja_id'] == $unit['id']) ? 'selected' : '' ?>>
                    <?= $unit['kode_unit'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="<?= $id ? 'update' : 'simpan' ?>"><?= $id ? 'Update' : 'Simpan' ?></button>
    </form>

    <hr>

    <h2>Daftar Paramedik</h2>
    <table>
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>Gender</th><th>Tempat/Tgl Lahir</th>
                <th>Kategori</th><th>Telepon</th><th>Alamat</th><th>Unit Kerja</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($paramedikkList as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['tmp_lahir']) ?> / <?= htmlspecialchars($row['tgr_lahir']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['telepon']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['unit_nama']) ?></td>
                <td>
                    <a href="paramedik.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="paramedik.php?delete=1&id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
